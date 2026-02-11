<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        $uk = Country::where('name', 'United Kingdom')->first();
        if (!$uk) return;

        $counties = [
            // England - Ceremonial Counties
            'Bedfordshire', 'Berkshire', 'Bristol', 'Buckinghamshire',
            'Cambridgeshire', 'Cheshire', 'Cornwall', 'Cumbria',
            'Derbyshire', 'Devon', 'Dorset', 'Durham',
            'East Sussex', 'Essex', 'Gloucestershire', 'Hampshire',
            'Herefordshire', 'Hertfordshire', 'Kent', 'Lancashire',
            'Leicestershire', 'Lincolnshire', 'Norfolk', 'North Yorkshire',
            'Northamptonshire', 'Northumberland', 'Nottinghamshire', 'Oxfordshire',
            'Rutland', 'Shropshire', 'Somerset', 'South Yorkshire',
            'Staffordshire', 'Suffolk', 'Surrey', 'Warwickshire',
            'West Midlands', 'West Sussex', 'West Yorkshire', 'Wiltshire',
            'Worcestershire', 'Isle of Wight', 'Isles of Scilly', 'Channel Islands',
            'East Riding of Yorkshire', 'North Somerset',

           // Greater / Metropolitan areas
            'Greater London', 'Greater Manchester', 'Merseyside', 'Tyne and Wear',

            // London boroughs
            'Camden', 'Greenwich', 'Hackney', 'Hammersmith and Fulham', 'Islington',
            'Kensington and Chelsea', 'Lambeth', 'Lewisham', 'Southwark', 'Tower Hamlets',
            'Wandsworth', 'Westminster', 'Barking and Dagenham', 'Barnet', 'Bexley', 'Brent',
            'Bromley', 'Croydon', 'Ealing', 'Enfield', 'Haringey', 'Harrow', 'Havering', 'Hillingdon',
            'Hounslow', 'Kingston upon Thames', 'Merton', 'Newham', 'Redbridge', 'Richmond upon Thames',
            'Sutton',

            // Common unitary authorities & boroughs (England)
            'Bath and North East Somerset', 'Bournemouth, Christchurch and Poole',
            'Brighton and Hove', 'Central Bedfordshire', 'Plymouth', 'Portsmouth', 'Southampton',
            'Leicester', 'Derby', 'Nottingham', 'Stoke-on-Trent', 'Milton Keynes', 'Slough',
            'Reading', 'Wokingham', 'Blackpool', 'Bradford',

            // Northern Ireland
            'Antrim', 'Armagh', 'Down', 'Fermanagh', 'Londonderry', 'Tyrone',
            'Ards and North Down', 'Mid and East Antrim', 'Causeway Coast and Glens',
            'Antrim and Newtownabbey', 'Newry Mourne and Down', 'Lisburn and Castlereagh',

            // Scotland — council areas
            'City of Edinburgh', 'Glasgow City', 'Aberdeen City', 'Dundee City', 'Highland',
            'Aberdeenshire', 'Fife', 'Perth and Kinross', 'Scottish Borders', 'South Lanarkshire',

            // Wales — principal areas
            'Cardiff', 'Swansea', 'Newport', 'Wrexham', 'Pembrokeshire', 'Conwy', 'Flintshire',

            // extras
            'North Lincolnshire', 'North East Lincolnshire', 'Medway', 'West Berkshire', 'Bracknell Forest'
        ];

        foreach ($counties as $name) {
            State::updateOrCreate([
                'country_id' => $uk->id,
                'name' => $name,
            ],
            ['is_active' => true]
            );
        }
    }
}
