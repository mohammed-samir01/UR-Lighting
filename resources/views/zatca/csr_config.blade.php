oid_section = OIDs
[OIDs]
certificateTemplateName = 1.3.6.1.4.1.311.20.2
[req]
default_bits = 2048
emailAddress = {{$emailAddress}}
req_extensions = v3_req
prompt = no
default_md = sha 256
req_extensions = req_ext
distinguished_name = dn
[dn]
C=SA
OU={{$organizationalUnitName}}
O={{$organizationName}}
CN={{$commonName}}
[v3_req]
basicConstraints = CA:FALSE
keyUsage = digitalSignature, nonRepudiation, keyEncipherment
[req_ext]
certificateTemplateName = ASN1:PRINTABLESTRING:ZATCA-Code-Signing
subjectAltName = dirName:alt_names
[alt_names]
SN={{$SN}}
UID={{$UID}}
title={{$title}}
registeredAddress={{$registeredAddress}}
businessCategory={{$businessCategory}}
