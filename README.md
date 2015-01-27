# MSISDN
MSISDN Lookup version 0.5.1 22.1.2015

Added Testing (phpUnit)

Setup:
- import info.sql into MySQL
- change DataBase info (App/DB.php)

Usage:
Shell version (shell.php)

Use: php shell.php +38640123456


![alt tag](http://shrani.si/f/3p/TQ/1tinqk7A/shell.jpg)

Web version (index.php)

input 


![alt tag](http://shrani.si/f/W/lo/3p4Zcj0G/web.jpg)


# Info
--------------------------------------------------------------
phpcpd ../../ --min-lines 3 --min-tokens 50 --exclude vendor --exclude coverage
phpcpd 2.0.1-11-gfadc61e by Sebastian Bergmann.

0.00% duplicated lines out of 449 total lines of code.

Time: 1.82 seconds, Memory: 2.75Mb

--------------------------------------------------------------

phpcs shell.php --standard=PSR2
phpcs index.php --standard=PSR2

phpcs App/Lookup.php --standard=PSR2
phpcs App/Tools.php --standard=PSR2
phpcs App/DB.php --standard=PSR2

phpcs Testing/LookupTest.php --standard=PSR2
phpcs Testing/ToolsTest.php --standard=PSR2
phpcs Testing/DBTest.php --standard=PSR2

--------------------------------------------------------------

php -l index.php
php -l shell.php

php -l App/DB.php
php -l App/Lookup.php
php -l App/Tools.php

php -l Testing/DBTest.php
php -l Testing/LookupTest.php
php -l Testing/ToolsTest.php


--------------------------------------------------------------

phpmd ../../ html codesize,design,naming,unusedcode,controversial --strict --reportfile ../../detect.html --exclude vendor


--------------------------------------------------------------

--------------------------------------------------------------
# Supports countries:
Abkhazia
Afghanistan
Albania
Algeria
American Samoa
Andorra
Angola
Anguilla
Antigua and Barbuda
Argentina Republic
Armenia
Aruba
Australia
Austria
Azerbaijan
Bahamas
Bahrain
Bangladesh
Barbados
Belarus
Belgium
Belize
Benin
Bermuda
Bhutan
Bolivia
Bosnia & Herzegov.
Botswana
Brazil
British Virgin Islands
Brunei
Bulgaria
Burkina Faso
Burma
Burundi
Cambodia
Cameroon
Canada
Cape Verde
Cayman Islands
Central African Rep.
Chad
Chile
China
Colombia
Comoros
Congo Dem. Rep.
Congo Republic
Cook Islands
Costa Rica
Croatia
Cuba
Curacao
Cyprus
Czech Rep.
Denmark
Djibouti
Dominica
Dominican Republic
Ecuador
Egypt
El Salvador
Equatorial Guinea
Eritrea
Estonia
Ethiopia
Falkland Islands (Malvinas)
Faroe Islands
Fiji
Finland
France
French Guiana
French Polynesia
Gabon
Gambia
Georgia
Germany
Ghana
Gibraltar
Greece
Greenland
Grenada
Guadeloupe
Guam
Guatemala
Guinea
Guinea-Bissau
Guyana
Haiti
Honduras
Hongkong China
Hungary
Iceland
India
Indonesia
International Networks
Iran
Iraq
Ireland
Israel
Italy
Ivory Coast
Jamaica
Japan
Jordan
Kazakhstan
Kenya
Kiribati
Korea N. Dem. People's Rep.
Korea S Republic of
Kuwait
Kyrgyzstan
Laos P.D.R.
Latvia
Lebanon
Lesotho
Liberia
Libya
Liechtenstein
Lithuania
Luxembourg
Macao China
Macedonia
Madagascar
Malawi
Malaysia
Maldives
Mali
Malta
Martinique (French Department of)
Mauritania
Mauritius
Mexico
Micronesia
Moldova
Monaco
Mongolia
Montenegro
Montserrat
Morocco
Mozambique
Namibia
Nepal
Netherlands
Netherlands Antilles
New Caledonia
New Zealand
Nicaragua
Niger
Nigeria
Niue
Norway
Oman
Pakistan
Palau (Republic of)
Palestinian Territory
Panama
Papua New Guinea
Paraguay
Peru
Philippines
Poland
Portugal
Puerto Rico
Qatar
Reunion
Romania
Russian Federation
Rwanda
Saint Kitts and Nevis
Saint Lucia
Samoa
San Marino
Sao Tome & Principe
Satellite Networks
Saudi Arabia
Senegal
Serbia
Seychelles
Sierra Leone
Singapore
Slovakia
Slovenia
Solomon Islands
Somalia
South Africa
South Sudan (Republic of)
Spain
Sri Lanka
St. Pierre & Miquelon
St. Vincent & Gren.
Sudan
Suriname
Swaziland
Sweden
Switzerland
Syrian Arab Republic
Taiwan
Tajikistan
Tanzania
Thailand
Timor-Leste
Togo
Tonga
Trinidad and Tobago
Tunisia
Turkey
Turkmenistan
Turks and Caicos Islands
Tuvalu
Uganda
Ukraine
United Arab Emirates
United Kingdom
United States
Uruguay
Uzbekistan
Vanuatu
Venezuela
Viet Nam
Virgin Islands U.S.
Yemen
Zambia
Zimbabwe 