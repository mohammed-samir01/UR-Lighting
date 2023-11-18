<?xml version="1.0" encoding="UTF-8"?>
<Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2"
         xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2"
         xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"
         xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">
    <ext:UBLExtensions>
        <ext:UBLExtension>
            <ext:ExtensionURI>urn:oasis:names:specification:ubl:dsig:enveloped:xades</ext:ExtensionURI>
            <ext:ExtensionContent>
                <!-- Please note that the signature values are sample values only -->
                <sig:UBLDocumentSignatures
                    xmlns:sig="urn:oasis:names:specification:ubl:schema:xsd:CommonSignatureComponents-2"
                    xmlns:sac="urn:oasis:names:specification:ubl:schema:xsd:SignatureAggregateComponents-2"
                    xmlns:sbc="urn:oasis:names:specification:ubl:schema:xsd:SignatureBasicComponents-2">
                    <sac:SignatureInformation>
                        <cbc:ID>urn:oasis:names:specification:ubl:signature:1</cbc:ID>
                        <sbc:ReferencedSignatureID>urn:oasis:names:specification:ubl:signature:Invoice
                        </sbc:ReferencedSignatureID>
                        <ds:Signature xmlns:ds="http://www.w3.org/2000/09/xmldsig#" Id="signature">
                            <ds:SignedInfo>
                                <ds:CanonicalizationMethod Algorithm="http://www.w3.org/2006/12/xml-c14n11"/>
                                <ds:SignatureMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha256"/>
                                <ds:Reference Id="invoiceSignedData" URI="">
                                    <ds:Transforms>
                                        <ds:Transform Algorithm="http://www.w3.org/TR/1999/REC-xpath-19991116">
                                            <ds:XPath>not(//ancestor-or-self::ext:UBLExtensions)</ds:XPath>
                                        </ds:Transform>
                                        <ds:Transform Algorithm="http://www.w3.org/TR/1999/REC-xpath-19991116">
                                            <ds:XPath>not(//ancestor-or-self::cac:Signature)</ds:XPath>
                                        </ds:Transform>
                                        <ds:Transform Algorithm="http://www.w3.org/TR/1999/REC-xpath-19991116">
                                            <ds:XPath>
                                                not(//ancestor-or-self::cac:AdditionalDocumentReference[cbc:ID='QR'])
                                            </ds:XPath>
                                        </ds:Transform>
                                        <ds:Transform Algorithm="http://www.w3.org/2006/12/xml-c14n11"/>
                                    </ds:Transforms>
                                    <ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"/>
                                    <ds:DigestValue></ds:DigestValue>
                                </ds:Reference>
                                <ds:Reference Type="http://www.w3.org/2000/09/xmldsig#SignatureProperties"
                                              URI="#xadesSignedProperties">
                                    <ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"/>
                                    <ds:DigestValue></ds:DigestValue>
                                </ds:Reference>
                            </ds:SignedInfo>
                            <ds:SignatureValue></ds:SignatureValue>
                            <ds:KeyInfo>
                                <ds:X509Data>
                                    <ds:X509Certificate>{{$certificate}}</ds:X509Certificate>
                                </ds:X509Data>
                            </ds:KeyInfo>
                            <ds:Object>
                                <xades:QualifyingProperties xmlns:xades="http://uri.etsi.org/01903/v1.3.2#"
                                                            Target="signature">
                                    <xades:SignedProperties Id="xadesSignedProperties">
                                        <xades:SignedSignatureProperties>
                                            <xades:SigningTime>{{$signDate}}</xades:SigningTime>
                                            <xades:SigningCertificate>
                                                <xades:Cert>
                                                    <xades:CertDigest>
                                                        <ds:DigestMethod
                                                            Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"/>
                                                        <ds:DigestValue>{{$hashCertificate}}</ds:DigestValue>
                                                    </xades:CertDigest>
                                                    <xades:IssuerSerial>
                                                        <ds:X509IssuerName>{{$issuerName}}</ds:X509IssuerName>
                                                        <ds:X509SerialNumber>{{$serialNuOfCert}}</ds:X509SerialNumber>
                                                    </xades:IssuerSerial>
                                                </xades:Cert>
                                            </xades:SigningCertificate>
                                        </xades:SignedSignatureProperties>
                                    </xades:SignedProperties>
                                </xades:QualifyingProperties>
                            </ds:Object>
                        </ds:Signature>
                    </sac:SignatureInformation>
                </sig:UBLDocumentSignatures>
            </ext:ExtensionContent>
        </ext:UBLExtension>
    </ext:UBLExtensions>

    <cbc:ProfileID>reporting:1.0</cbc:ProfileID>
    <cbc:ID>{{$invoice->id}}</cbc:ID>
    <cbc:UUID>{{$invoice->uuid}}</cbc:UUID>
    <cbc:IssueDate>{{$invoice->created_at->format('Y-m-d')}}</cbc:IssueDate>
    <cbc:IssueTime>{{$invoice->created_at->format('H:i:s\Z')}}</cbc:IssueTime>
    <cbc:InvoiceTypeCode name="0200000">{{$invoice->type_invoice}}</cbc:InvoiceTypeCode>
    <cbc:DocumentCurrencyCode>SAR</cbc:DocumentCurrencyCode>
    <cbc:TaxCurrencyCode>SAR</cbc:TaxCurrencyCode>
    @if($invoice->type_invoice == '383' || $invoice->type_invoice == '381')
    <cac:BillingReference>
        <cac:InvoiceDocumentReference>
            <cbc:ID>Invoice Number: {{$invoice->father_inv}}; Invoice Issue Date: 2023-11-18</cbc:ID>
        </cac:InvoiceDocumentReference>
    </cac:BillingReference>
    @endif
    <cac:AdditionalDocumentReference>
        <cbc:ID>ICV</cbc:ID>
        <cbc:UUID>10</cbc:UUID>
    </cac:AdditionalDocumentReference>
    <cac:AdditionalDocumentReference>
        <cbc:ID>PIH</cbc:ID>
        <cac:Attachment>
            <cbc:EmbeddedDocumentBinaryObject
                mimeCode="text/plain">{{$invoice->pih?? 'NWZlY2ViNjZmZmM4NmYzOGQ5NTI3ODZjNmQ2OTZjNzljMmRiYzIzOWRkNGU5MWI0NjcyOWQ3M2EyN2ZiNTdlOQ=='}}</cbc:EmbeddedDocumentBinaryObject>
        </cac:Attachment>
    </cac:AdditionalDocumentReference>


    <cac:AdditionalDocumentReference>
        <cbc:ID>QR</cbc:ID>
        <cac:Attachment>
            <cbc:EmbeddedDocumentBinaryObject mimeCode="text/plain"></cbc:EmbeddedDocumentBinaryObject>
        </cac:Attachment>
    </cac:AdditionalDocumentReference>
    <cac:Signature>
        <cbc:ID>urn:oasis:names:specification:ubl:signature:Invoice</cbc:ID>
        <cbc:SignatureMethod>urn:oasis:names:specification:ubl:dsig:enveloped:xades</cbc:SignatureMethod>
    </cac:Signature>
    <cac:AccountingSupplierParty>
        <cac:Party>
            <cac:PartyIdentification>
                <cbc:ID schemeID="CRN">{{$invoice->seller->commercial_num}}</cbc:ID>
            </cac:PartyIdentification>
            <cac:PostalAddress>
                <cbc:StreetName>{{$invoice->seller->address}}</cbc:StreetName>
                <cbc:BuildingNumber>{{$invoice->seller->build_num}}</cbc:BuildingNumber>
                <cbc:PlotIdentification>{{$invoice->seller->additional_num}}</cbc:PlotIdentification>
                <cbc:CitySubdivisionName>{{$invoice->seller->subdivision}}</cbc:CitySubdivisionName>
                <cbc:CityName>{{$invoice->seller->city_name}}</cbc:CityName>
                <cbc:PostalZone>{{$invoice->seller->zib}}</cbc:PostalZone>
                <cac:Country>
                    <cbc:IdentificationCode>SA</cbc:IdentificationCode>
                </cac:Country>
            </cac:PostalAddress>
            <cac:PartyTaxScheme>
                <cbc:CompanyID>{{$invoice->seller->tax_num}}</cbc:CompanyID>
                <cac:TaxScheme>
                    <cbc:ID>VAT</cbc:ID>
                </cac:TaxScheme>
            </cac:PartyTaxScheme>
            <cac:PartyLegalEntity>
                <cbc:RegistrationName>{{$invoice->seller->company_name}}</cbc:RegistrationName>
            </cac:PartyLegalEntity>
        </cac:Party>
    </cac:AccountingSupplierParty>
    <cac:AccountingCustomerParty>
        <cac:Party>
            <cac:PostalAddress>
               <cbc:StreetName>{{$invoice->shipping_address_data->address}}</cbc:StreetName>
                <cbc:CitySubdivisionName/>
               <cbc:CityName>{{$invoice->shipping_address_data->city->name_en}}</cbc:CityName>
                <cac:Country>
                    <cbc:IdentificationCode>SA</cbc:IdentificationCode>
                </cac:Country>
            </cac:PostalAddress>
            <cac:PartyTaxScheme>
                <cac:TaxScheme>
                    <cbc:ID>VAT</cbc:ID>
                </cac:TaxScheme>
            </cac:PartyTaxScheme>
            <cac:PartyLegalEntity>
                <cbc:RegistrationName>{{$invoice->shipping_address_data->contact_person_name}}</cbc:RegistrationName>
            </cac:PartyLegalEntity>
        </cac:Party>
    </cac:AccountingCustomerParty>
    <cac:PaymentMeans>
        <cbc:PaymentMeansCode>10</cbc:PaymentMeansCode>
        @if($invoice->type_invoice == '383' || $invoice->type_invoice == '381')
        <cbc:InstructionNote>Returned items?</cbc:InstructionNote>
        @endif
    </cac:PaymentMeans>
    <cac:AllowanceCharge>
        <cbc:ChargeIndicator>false</cbc:ChargeIndicator>
        <cbc:AllowanceChargeReason>discount</cbc:AllowanceChargeReason>
        <cbc:Amount currencyID="SAR">0.00</cbc:Amount>
        <cac:TaxCategory>
            <cbc:ID schemeID="UN/ECE 5305" schemeAgencyID="6">S</cbc:ID>
            <cbc:Percent>15</cbc:Percent>
            <cac:TaxScheme>
                <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">VAT</cbc:ID>
            </cac:TaxScheme>
        </cac:TaxCategory>
        <cac:TaxCategory>
            <cbc:ID schemeID="UN/ECE 5305" schemeAgencyID="6">S</cbc:ID>
            <cbc:Percent>15</cbc:Percent>
            <cac:TaxScheme>
                <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">VAT</cbc:ID>
            </cac:TaxScheme>
        </cac:TaxCategory>
    </cac:AllowanceCharge>
    <cac:TaxTotal>
        <cbc:TaxAmount currencyID="SAR">{{number_format($invoice->summary->total_tax,2,'.','') }}</cbc:TaxAmount>
    </cac:TaxTotal>
    <cac:TaxTotal>
        <cbc:TaxAmount currencyID="SAR">{{number_format($invoice->summary->total_tax,2,'.','') }}</cbc:TaxAmount>
        <cac:TaxSubtotal>
            <cbc:TaxableAmount currencyID="SAR">{{number_format($invoice->summary->subtotal,2,'.','') }}</cbc:TaxableAmount>
            <cbc:TaxAmount currencyID="SAR">{{number_format($invoice->summary->total_tax,2,'.','') }}</cbc:TaxAmount>
            <cac:TaxCategory>
                <cbc:ID schemeID="UN/ECE 5305" schemeAgencyID="6">S</cbc:ID>
                <cbc:Percent>15.00</cbc:Percent>
                <cac:TaxScheme>
                    <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">VAT</cbc:ID>
                </cac:TaxScheme>
            </cac:TaxCategory>
        </cac:TaxSubtotal>
    </cac:TaxTotal>
    <cac:LegalMonetaryTotal>
        <cbc:LineExtensionAmount currencyID="SAR">{{number_format($invoice->summary->subtotal,2,'.','') }}</cbc:LineExtensionAmount>
        <cbc:TaxExclusiveAmount currencyID="SAR">{{number_format($invoice->summary->subtotal,2,'.','') }}</cbc:TaxExclusiveAmount>
        <cbc:TaxInclusiveAmount currencyID="SAR">{{number_format($invoice->summary->subtotal + $invoice->summary->total_tax,2,'.','')}}</cbc:TaxInclusiveAmount>
        <cbc:AllowanceTotalAmount currencyID="SAR">0.00</cbc:AllowanceTotalAmount>
        <cbc:PrepaidAmount currencyID="SAR">0.00</cbc:PrepaidAmount>
        <cbc:PayableAmount currencyID="SAR">{{number_format($invoice->summary->subtotal + $invoice->summary->total_tax,2,'.','')}}</cbc:PayableAmount>
    </cac:LegalMonetaryTotal>
    @foreach($invoice->details as $product)
        <cac:InvoiceLine>
            <cbc:ID>1</cbc:ID>
            <cbc:InvoicedQuantity unitCode="PCE">{{$product->qty}}</cbc:InvoicedQuantity>
            <cbc:LineExtensionAmount
                currencyID="SAR">{{number_format($product->selling_price * $product->qty,2,'.','')}}</cbc:LineExtensionAmount>
            <cac:TaxTotal>
                <cbc:TaxAmount currencyID="SAR">{{number_format($product->tax,2,'.','') }}</cbc:TaxAmount>
                <cbc:RoundingAmount
                    currencyID="SAR">{{number_format($product->price * $product->qty ,2,'.','') }}</cbc:RoundingAmount>
            </cac:TaxTotal>
            <cac:Item>
                <cbc:Name>{{json_decode($product->product_details)->name}}</cbc:Name>
                <cac:ClassifiedTaxCategory>
                    <cbc:ID>S</cbc:ID>
                    <cbc:Percent>15.00</cbc:Percent>
                    <cac:TaxScheme>
                        <cbc:ID>VAT</cbc:ID>
                    </cac:TaxScheme>
                </cac:ClassifiedTaxCategory>
            </cac:Item>
            <cac:Price>
                <cbc:PriceAmount currencyID="SAR">{{number_format($product->selling_price,2,'.','') }}</cbc:PriceAmount>
                <cac:AllowanceCharge>
                    <cbc:ChargeIndicator>true</cbc:ChargeIndicator>
                    <cbc:AllowanceChargeReason>discount</cbc:AllowanceChargeReason>
                    <cbc:Amount currencyID="SAR">0.00</cbc:Amount>
                </cac:AllowanceCharge>
            </cac:Price>
        </cac:InvoiceLine>
    @endforeach

</Invoice>
