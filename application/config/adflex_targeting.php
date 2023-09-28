<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | allow the display of their own advertising campaigns on their sites - set to false on the prod
  |--------------------------------------------------------------------------
 */
$config['show_own_camps'] = (ENVIRONMENT !== 'production');



/*
  |--------------------------------------------------------------------------
  | The mode of displaying ads without taking into account geo targeting. Useful in development - set to true on the prod
  |--------------------------------------------------------------------------
 */
$config['enable_geotargeting'] = (ENVIRONMENT === 'production');



/*
  |--------------------------------------------------------------------------
  | banners_sizes
  |--------------------------------------------------------------------------
 */
$config['banners_sizes'] = [
    '468x60',
    '728x90',
    '250x250',
    '200x200',
    '336x280',
    '300x250',
    '120x600',
    '160x600',
    '300x600',
    '240x400',
    '970x90',
    '970x250',
    '320x100',
    '320x50',
    '600x200',
    '468x120'
];


/*
  |--------------------------------------------------------------------------
  | themes
  |--------------------------------------------------------------------------
 */
$config['themes'] = [
    'auto_moto',
    'business_finance',
    'house_family',
    'health_fitness',
    'games',
    'career_work',
    'cinema',
    'beauty_cosmetics',
    'cookery',
    'fashion_clothes',
    'music',
    'the_property',
    'news',
    'society',
    'entertainment',
    'sport',
    'science',
    'goods',
    'tourism',
    'adult',
    'other'
];


/*
  |--------------------------------------------------------------------------
  | devs
  |--------------------------------------------------------------------------
 */
$config['devs'] = [
    'Computer',
    'Tablet',
    'Mobile'
];


/*
  |--------------------------------------------------------------------------
  | platforms
  |--------------------------------------------------------------------------
 */
$config['platforms'] = [
    'Windows_10',
    'Windows_8_1',
    'Windows_8',
    'Windows_7',
    'Windows_Vista',
    'Windows_XP',
    'Mac_OS',
    'Ubuntu',
    'Linux',
    'unknown_desktop_os',
    'iOS',
    'Android',
    'Windows_Phone',
    'Symbian',
    'Black_Berry',
    'Windows_Mobile',
    'unknown_mobile_os'
];


/*
  |--------------------------------------------------------------------------
  | browsers
  |--------------------------------------------------------------------------
 */
$config['browsers'] = [
    'Chrome_d',
    'Firefox_d',
    'Opera_d',
    'IE_d',
    'Edge_d',
    'Maxthon_d',
    'Safari_d',
    'unknown_desktop_browser',
    'Chrome_m',
    'Android_m',
    'Opera_m',
    'Dolphin_m',
    'Firefox_m',
    'UCBrowser_m',
    'Puffin_m',
    'Safari_m',
    'Edge_m',
    'IE_m',
    'unknown_mobile_browser'
];


/*
  |--------------------------------------------------------------------------
  | days
  |--------------------------------------------------------------------------
 */
$config['days'] = ['1', '2', '3', '4', '5', '6', '7'];


/*
  |--------------------------------------------------------------------------
  | hours
  |--------------------------------------------------------------------------
 */
$config['hours'] = [
    '00', '01', '02', '03', '04', '05', '06', '07', '08',
    '09', '10', '11', '12', '13', '14', '15', '16', '17',
    '18', '19', '20', '21', '22', '23'
];


/*
  |--------------------------------------------------------------------------
  | geos
  |--------------------------------------------------------------------------
 */
$config['geo_alfa2'] = [
    'XX', 'AF', 'AX', 'AL', 'DZ', 'AS', 'AD', 'AO', 'AI',
    'AQ', 'AG', 'AR', 'AM', 'AW', 'AU', 'AT', 'AZ', 'BS', 'BH', 'BD',
    'BB', 'BY', 'BE', 'BZ', 'BJ', 'BM', 'BT', 'BO', 'BQ', 'BA', 'BW',
    'BV', 'BR', 'IO', 'BN', 'BG', 'BF', 'BI', 'KH', 'CM', 'CA', 'CV',
    'KY', 'CF', 'TD', 'CL', 'CN', 'CX', 'CC', 'CO', 'KM', 'CG', 'CD',
    'CK', 'CR', 'CI', 'HR', 'CU', 'CW', 'CY', 'CZ', 'DK', 'DJ', 'DM',
    'DO', 'EC', 'EG', 'SV', 'GQ', 'ER', 'EE', 'ET', 'FK', 'FO', 'FJ',
    'FI', 'FR', 'GF', 'PF', 'TF', 'GA', 'GM', 'GE', 'DE', 'GH', 'GI',
    'GR', 'GL', 'GD', 'GP', 'GU', 'GT', 'GG', 'GN', 'GW', 'GY', 'HT',
    'HM', 'VA', 'HN', 'HK', 'HU', 'IS', 'IN', 'ID', 'IR', 'IQ', 'IE',
    'IM', 'IL', 'IT', 'JM', 'JP', 'JE', 'JO', 'KZ', 'KE', 'KI', 'KP',
    'KR', 'KW', 'KG', 'LA', 'LV', 'LB', 'LS', 'LR', 'LY', 'LI', 'LT',
    'LU', 'MO', 'MK', 'MG', 'MW', 'MY', 'MV', 'ML', 'MT', 'MH', 'MQ',
    'MR', 'MU', 'YT', 'MX', 'FM', 'MD', 'MC', 'MN', 'ME', 'MS', 'MA',
    'MZ', 'MM', 'NA', 'NR', 'NP', 'NL', 'NC', 'NZ', 'NI', 'NE', 'NG',
    'NU', 'NF', 'MP', 'NO', 'OM', 'PK', 'PW', 'PS', 'PA', 'PG', 'PY',
    'PE', 'PH', 'PN', 'PL', 'PT', 'PR', 'QA', 'RE', 'RO', 'RU', 'RW',
    'BL', 'SH', 'KN', 'LC', 'MF', 'PM', 'VC', 'WS', 'SM', 'ST', 'SA',
    'SN', 'RS', 'SC', 'SL', 'SG', 'SX', 'SK', 'SI', 'SB', 'SO', 'ZA',
    'GS', 'SS', 'ES', 'LK', 'SD', 'SR', 'SJ', 'SZ', 'SE', 'CH', 'SY',
    'TW', 'TJ', 'TZ', 'TH', 'TL', 'TG', 'TK', 'TO', 'TT', 'TN', 'TR',
    'TM', 'TC', 'TV', 'UG', 'UA', 'AE', 'GB', 'US', 'UM', 'UY', 'UZ',
    'VU', 'VE', 'VN', 'VG', 'VI', 'WF', 'EH', 'YE', 'ZM', 'ZW'
];

$config['geo_alfa3'] = [
    'XXX', 'AFG', 'ALA', 'ALB', 'DZA', 'ASM', '_AND',
    'AGO', 'AIA', 'ATA', 'ATG', 'ARG', 'ARM', 'ABW', 'AUS', 'AUT',
    'AZE', 'BHS', 'BHR', 'BGD', 'BRB', 'BLR', 'BEL', 'BLZ', 'BEN',
    'BMU', 'BTN', 'BOL', 'BES', 'BIH', 'BWA', 'BVT', 'BRA', 'IOT',
    'BRN', 'BGR', 'BFA', 'BDI', 'KHM', 'CMR', 'CAN', 'CPV', 'CYM',
    'CAF', 'TCD', 'CHL', 'CHN', 'CXR', 'CCK', 'COL', 'COM', 'COG',
    'COD', 'COK', 'CRI', 'CIV', 'HRV', 'CUB', 'CUW', 'CYP', 'CZE',
    'DNK', 'DJI', 'DMA', 'DOM', 'ECU', 'EGY', 'SLV', 'GNQ', 'ERI',
    'EST', 'ETH', 'FLK', 'FRO', 'FJI', 'FIN', 'FRA', 'GUF', 'PYF',
    'ATF', 'GAB', 'GMB', 'GEO', 'DEU', 'GHA', 'GIB', 'GRC', 'GRL',
    'GRD', 'GLP', 'GUM', 'GTM', 'GGY', 'GIN', 'GNB', 'GUY', 'HTI',
    'HMD', 'VAT', 'HND', 'HKG', 'HUN', 'ISL', 'IND', 'IDN', 'IRN',
    'IRQ', 'IRL', 'IMN', 'ISR', 'ITA', 'JAM', 'JPN', 'JEY', 'JOR',
    'KAZ', 'KEN', 'KIR', 'PRK', 'KOR', 'KWT', 'KGZ', 'LAO', 'LVA',
    'LBN', 'LSO', 'LBR', 'LBY', 'LIE', 'LTU', 'LUX', 'MAC', 'MKD',
    'MDG', 'MWI', 'MYS', 'MDV', 'MLI', 'MLT', 'MHL', 'MTQ', 'MRT',
    'MUS', 'MYT', 'MEX', 'FSM', 'MDA', 'MCO', 'MNG', 'MNE', 'MSR',
    'MAR', 'MOZ', 'MMR', 'NAM', 'NRU', 'NPL', 'NLD', 'NCL', 'NZL',
    'NIC', 'NER', 'NGA', 'NIU', 'NFK', 'MNP', 'NOR', 'OMN', 'PAK',
    'PLW', 'PSE', 'PAN', 'PNG', 'PRY', 'PER', 'PHL', 'PCN', 'POL',
    'PRT', 'PRI', 'QAT', 'REU', 'ROU', 'RUS', 'RWA', 'BLM', 'SHN',
    'KNA', 'LCA', 'MAF', 'SPM', 'VCT', 'WSM', 'SMR', 'STP', 'SAU',
    'SEN', 'SRB', 'SYC', 'SLE', 'SGP', 'SXM', 'SVK', 'SVN', 'SLB',
    'SOM', 'ZAF', 'SGS', 'SSD', 'ESP', 'LKA', 'SDN', 'SUR', 'SJM',
    'SWZ', 'SWE', 'CHE', 'SYR', 'TWN', 'TJK', 'TZA', 'THA', 'TLS',
    'TGO', 'TKL', 'TON', 'TTO', 'TUN', 'TUR', 'TKM', 'TCA', 'TUV',
    'UGA', 'UKR', 'ARE', 'GBR', 'USA', 'UMI', 'URY', 'UZB', 'VUT',
    'VEN', 'VNM', 'VGB', 'VIR', 'WLF', 'ESH', 'YEM', 'ZMB', 'ZWE'
];

$config['geo_numeric'] = [
    '000', '004', '248', '008', '012', '016', '020', '024', '660',
    '010', '028', '032', '051', '533', '036', '040', '031', '044',
    '048', '050', '052', '112', '056', '084', '204', '060', '064',
    '068', '535', '070', '072', '074', '076', '086', '096', '100',
    '854', '108', '116', '120', '124', '132', '136', '140', '148',
    '152', '156', '162', '166', '170', '174', '178', '180', '184',
    '188', '384', '191', '192', '531', '196', '203', '208', '262',
    '212', '214', '218', '818', '222', '226', '232', '233', '231',
    '238', '234', '242', '246', '250', '254', '258', '260', '266',
    '270', '268', '276', '288', '292', '300', '304', '308', '312',
    '316', '320', '831', '324', '624', '328', '332', '334', '336',
    '340', '344', '348', '352', '356', '360', '364', '368', '372',
    '833', '376', '380', '388', '392', '832', '400', '398', '404',
    '296', '408', '410', '414', '417', '418', '428', '422', '426',
    '430', '434', '438', '440', '442', '446', '807', '450', '454',
    '458', '462', '466', '470', '584', '474', '478', '480', '175',
    '484', '583', '498', '492', '496', '499', '500', '504', '508',
    '104', '516', '520', '524', '528', '540', '554', '558', '562',
    '566', '570', '574', '580', '578', '512', '586', '585', '275',
    '591', '598', '600', '604', '608', '612', '616', '620', '630',
    '634', '638', '642', '643', '646', '652', '654', '659', '662',
    '663', '666', '670', '882', '674', '678', '682', '686', '688',
    '690', '694', '702', '534', '703', '705', '090', '706', '710',
    '239', '728', '724', '144', '729', '740', '744', '748', '752',
    '756', '760', '158', '762', '834', '764', '626', '768', '772',
    '776', '780', '788', '792', '795', '796', '798', '800', '804',
    '784', '826', '840', '581', '858', '860', '548', '862', '704',
    '092', '850', '876', '732', '887', '894', '716'
];


$config['geo_name'] = [
    'unknown', 'Afghanistan', 'Åland Islands',
    'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 'Anguilla',
    'Antarctica', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Aruba',
    'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh',
    'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan',
    'Bolivia (Plurinational State of)', 'Bonaire', 'Bosnia and Herzegovina',
    'Botswana', 'Bouvet Island', 'Brazil', 'British Indian Ocean Territory',
    'Brunei Darussalam', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia',
    'Cameroon', 'Canada', 'Cabo Verde', 'Cayman Islands',
    'Central African Republic', 'Chad', 'Chile', 'China', 'Christmas Island',
    'Cocos (Keeling) Islands', 'Colombia', 'Comoros', 'Congo',
    'Congo (Democratic Republic of the)', 'Cook Islands', 'Costa Rica',
    'Côte d`Ivoire', 'Croatia', 'Cuba', 'Curaçao', 'Cyprus', 'Czech Republic',
    'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'Ecuador',
    'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia',
    'Ethiopia', 'Falkland Islands (Malvinas)', 'Faroe Islands', 'Fiji',
    'Finland', 'France', 'French Guiana', 'French Polynesia',
    'French Southern Territories', 'Gabon', 'Gambia', 'Georgia', 'Germany',
    'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe',
    'Guam', 'Guatemala', 'Guernsey', 'Guinea', 'Guinea-Bissau', 'Guyana',
    'Haiti', 'Heard Island and McDonald Islands', 'Holy See', 'Honduras',
    'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia',
    'Iran (Islamic Republic of)', 'Iraq', 'Ireland', 'Isle of Man',
    'Israel', 'Italy', 'Jamaica', 'Japan', 'Jersey', 'Jordan', 'Kazakhstan',
    'Kenya', 'Kiribati', 'Korea (Democratic People`s Republic of)',
    'Korea (Republic of)', 'Kuwait', 'Kyrgyzstan',
    'Lao People`s Democratic Republic', 'Latvia', 'Lebanon', 'Lesotho',
    'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macao',
    'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali',
    'Malta', 'Marshall Islands', 'Martinique', 'Mauritania', 'Mauritius',
    'Mayotte', 'Mexico', 'Micronesia (Federated States of)',
    'Moldova (Republic of)', 'Monaco', 'Mongolia', 'Montenegro',
    'Montserrat', 'Morocco', 'Mozambique', 'Myanmar', 'Namibia', 'Nauru',
    'Nepal', 'Netherlands', 'New Caledonia', 'New Zealand', 'Nicaragua',
    'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'Northern Mariana Islands',
    'Norway', 'Oman', 'Pakistan', 'Palau', 'Palestine', 'Panama',
    'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Pitcairn',
    'Poland', 'Portugal', 'Puerto Rico', 'Qatar', 'Réunion', 'Romania',
    'Russian Federation', 'Rwanda', 'Saint Barthélemy', 'Saint Helena',
    'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Martin (French part)',
    'Saint Pierre and Miquelon', 'Saint Vincent and the Grenadines', 'Samoa',
    'San Marino', 'Sao Tome and Principe', 'Saudi Arabia', 'Senegal', 'Serbia',
    'Seychelles', 'Sierra Leone', 'Singapore', 'Sint Maarten (Dutch part)',
    'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa',
    'South Georgia and the South Sandwich Islands', 'South Sudan', 'Spain',
    'Sri Lanka', 'Sudan', 'Suriname', 'Svalbard and Jan Mayen', 'Swaziland',
    'Sweden', 'Switzerland', 'Syrian Arab Republic', 'Taiwan (Province of China)',
    'Tajikistan', 'Tanzania', 'Thailand', 'Timor-Leste', 'Togo', 'Tokelau',
    'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan',
    'Turks and Caicos Islands', 'Tuvalu', 'Uganda', 'Ukraine',
    'United Arab Emirates', 'United Kingdom of Great Britain and Northern Ireland',
    'United States of America', 'United States Minor Outlying Islands',
    'Uruguay', 'Uzbekistan', 'Vanuatu', 'Venezuela (Bolivarian Republic of)',
    'Viet Nam', 'Virgin Islands (British)', 'Virgin Islands (U.S.)',
    'Wallis and Futuna', 'Western Sahara', 'Yemen', 'Zambia', 'Zimbabwe'
];
