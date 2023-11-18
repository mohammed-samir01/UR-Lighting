<?php


namespace App\Services\Zatca;


use App\CPU\Helpers;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class GenerateCsr
{

    public function csr($request)
    {
        $data = [
            'SN' => $this->generateGuid(),
            'UID' => $request->uid,
            'title' => '0100',
            'registeredAddress' => $request->address,
            'businessCategory' => 'Industry',
            'emailAddress' => $request->email
        ];
        $dn = [
            "commonName" => $request->organization_name . '-' . $request->uid,
            "organizationName" => $request->organization_name,
            "organizationalUnitName" => 'pc-1',
            "countryName" => 'SA',
        ];
        $configFile = tempnam(sys_get_temp_dir(), '_csr');
        \File::put($configFile, \View::make('zatca.csr_config', array_merge($data, $dn))->render());

        $config['config'] = $configFile;
        $new_config = array(
                "private_key_type" => OPENSSL_KEYTYPE_EC,
                "curve_name" => "secp256k1",
                "digest_alg" => 'sha256'
            ) + $config;
        $privateKey = openssl_pkey_new($new_config);
        openssl_pkey_export($privateKey, $privkey, null, $new_config);

        $lines = [];
        foreach (explode("\n", $privkey) as $value) {
            if (substr($value, 0, 5) != "-----")
                $lines[] = $value;
        }
        $pem_key = join("", $lines);
        Storage::disk('zatca')->put(Helpers::path_zatca().'/priv_key.pem', $pem_key);
        $csr_resources = openssl_csr_new($dn, $privkey, ["digest_alg" => 'sha256'] + $config);
        openssl_csr_export($csr_resources, $csr);
        if (\File::exists($configFile))
            \File::delete($configFile);
        return base64_encode($csr);

    }

    public function generateGuid()
    {
        if (function_exists('com_create_guid') === true) {
            $guid = trim(com_create_guid(), '{}');
        } else {
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45); // "-"
            $guid = substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12)
                . chr(125); // "}"
        }
        return "1-TST|2-TST|3-" . $guid;
    }
}
