<?php

namespace App\Services\Zatca;

use App\CPU\Helpers;
use App\Services\Zatca\InvoiceHashTag;
use App\Services\Zatca\InvoiceSignatureTag;
use App\Services\Zatca\PublicKeyOfCertTag;
use App\Services\Zatca\SignOfCertTag;
use DOMXPath;
use EllipticCurve\Ecdsa;
use EllipticCurve\PrivateKey;
use Illuminate\Support\Facades\Storage;
use phpseclib3\File\X509;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;

class GenerateXmlFile
{
    private $xml;
    private $x509Cert;
    private $xCert;
    private $signDate;
    private $invoice;
    private $hashInvoice;
    private $type;

    public function __construct($type = 'cert')
    {
        $this->type = $type;
        $this->xCert = $this->x509();
        $this->signDate = date('Y-m-d\TH:i:s\Z', strtotime(now()));
    }

    public function loadXmlFile($invoice)
    {
        $this->invoice = $invoice;
        $invoice->pih = null;
        $signDate = $this->signDate;
        $issuerName = $this->getIssuerName();
        $serialNuOfCert = $this->getSerialNuOfCert();
        $hashCertificate = $this->hashCertificate();
        $certificate = $this->getCertificate();
        $this->xml = \View::make('zatca.zatca', compact('signDate', 'issuerName',
            'serialNuOfCert', 'hashCertificate', 'certificate', 'invoice'))->render();
//        return $this->createXmlFile();
        return $this->data_to_zatca();

        dd($this->xml);
//        $this->xml = file_get_contents(public_path('empty.xml'));
//        $this->xml = file_get_contents(public_path('Standard_Debit_Note.xml'));
        return $this->qrCode();
    }

    public function data_to_zatca()
    {
        $invoice_xml = $this->createXml();
        return [
            "invoiceHash" => base64_encode($this->hashInvoice),
            "uuid" => $this->invoice->uuid,
            "invoice" => base64_encode($invoice_xml),
        ];
    }

    public function hashWithoutEncode()
    {
        $xml = $this->loadXml($this->xml);
        $elements = ['UBLExtensions' => 0, 'AdditionalDocumentReference' => 2, 'Signature' => 0];
        foreach ($elements as $removed => $index) {
            $remove = $xml->getElementsByTagName($removed)[$index];
            if ($remove)
                $remove->parentNode->removeChild($remove);
        }
        return hash('sha256', $xml->C14N(), true);
    }

    public function signed_properties_hash()
    {
        $xml = $this->loadXml($this->xml);
        $xpath = new DOMXPath($xml);
        $xpath->registerNamespace('xades', 'http://uri.etsi.org/01903/v1.3.2#');
        $elems = $xpath->query('//xades:SignedProperties')[0];
        $elems->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:xades', 'http://uri.etsi.org/01903/v1.3.2#');
        $children = ['DigestMethod', 'DigestValue', 'X509IssuerName', 'X509SerialNumber'];
        foreach ($children as $child) {
            $child = $elems->getElementsByTagName($child)[0];
            $child->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:ds', 'http://www.w3.org/2000/09/xmldsig#');
        }
        return base64_encode(hash('sha256', $xml->saveXML($elems)));
    }

    public function createXml()
    {
        $xml = $this->loadXml($this->xml);
        $hashTag = $xml->getElementsByTagName('DigestValue')[0];
        $this->hashInvoice = $this->hashWithoutEncode();
        $hash_invoice_encode = base64_encode($this->hashInvoice);
        $hashTag->nodeValue = $hash_invoice_encode;
        $signPropertiesTag = $xml->getElementsByTagName('DigestValue')[1];
        $signPropertiesTag->nodeValue = $this->signed_properties_hash();
        $signatureTag = $xml->getElementsByTagName('SignatureValue')[0];
        $signature_invoice = $this->signature_invoice();
        $signatureTag->nodeValue = $signature_invoice;
        $qrTag = $xml->getElementsByTagName('EmbeddedDocumentBinaryObject')[1];
        $qrTag->nodeValue = $this->qrCode($hash_invoice_encode, $signature_invoice);
        return $xml->saveXML();
    }

    public function createXmlFile()
    {
        file_put_contents(public_path('empty.xml'), $this->createXml());
        return 'ok';
    }

    private function x509()
    {
        $x509 = new X509();
        $cert = $x509->loadX509($this->getCertificate());
        $this->x509Cert = $x509;
        return $cert;
    }

    private function getIssuerName()
    {
        return $this->x509Cert->getIssuerDN(X509::DN_STRING);
    }

    private function getSignatureOfCert()
    {
        return trim($this->xCert['signature']);
    }

    private function getSerialNuOfCert()
    {
        return strval($this->xCert['tbsCertificate']['serialNumber']);
    }

    public function getCertificate()
    {
        return Helpers::csrOrCert($this->type);
    }

    private function hashCertificate()
    {
        return base64_encode(hash('sha256', $this->getCertificate()));
    }

    private function loadXml($xmlFile)
    {
        $xml = new \DOMDocument();
        $xml->loadXML($xmlFile);
        return $xml;
    }

    private function qrCode($hash_invoice_encode, $signature_invoice)
    {
        return GenerateQrCode::fromArray([
            new Seller($this->invoice->seller->company_name), // seller name
            new TaxNumber($this->invoice->seller->tax_num), // seller tax number
            new InvoiceDate(date('Y-m-d\TH:i:s\Z', strtotime($this->invoice->created_at))), // invoice date as Zulu ISO8601
            new InvoiceTotalAmount(number_format($this->invoice->summary->subtotal + $this->invoice->summary->total_tax, 2, '.', '')), // invoice total amount
            new InvoiceTaxAmount(number_format($this->invoice->summary->total_tax, 2, '.', '')),// invoice tax amount
            new InvoiceHashTag($hash_invoice_encode), // invoice hash
            new InvoiceSignatureTag($signature_invoice), // signature of invoice
            new PublicKeyOfCertTag($this->getPublicKey()), // public key of certificate
            new SignOfCertTag($this->getSignatureOfCert()), // sign of cert
        ])->toBase64();
    }

    private function getPublicKey()
    {
        return $this->toDer($this->x509Cert->getPublicKey());
    }

    private function signature_invoice()
    {
        $path = Helpers::path_zatca() . '/priv_key.pem';
        if (Storage::disk('zatca')->exists($path)) {
            $private_key = Storage::disk('zatca')->get($path);
            $private_key_pem = PrivateKey::fromString($private_key);
            $signature = Ecdsa::sign($this->hashInvoice, $private_key_pem);
            return $signature->toBase64();
        }
        throw new \Exception('private key is not found');
    }

    private function toDer($pem)
    {
        $lines = array();
        foreach (explode("\n", $pem) as $value) {
            if (substr($value, 0, 5) !== "-----") {
                array_push($lines, $value);
            }
        }
        $pem_data = join("", $lines);
        return base64_decode($pem_data);
    }
}
