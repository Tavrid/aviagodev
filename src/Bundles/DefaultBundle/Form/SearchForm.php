<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 02.09.14
 * Time: 23:23
 */

namespace Bundles\DefaultBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;


/**
 * Class SearchForm
 * @package Bundles\DefaultBundle\Form
 *
 *
 *
 */
class SearchForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $adults = array();
        for ($i = 1; $i < 10; $i++) {
            $adults[$i] = $i;
        }
        $children = array();
        for ($i = 0; $i < 5; $i++) {
            $children[$i] = $i;
        }

        $infant = array();
        for ($i = 0; $i < 5; $i++) {
            $infant[$i] = $i;
        }
        $builder->add('city_from', 'text', [
            'label' => 'Из:',
            'mapped' => false,
            'attr' => ['placeholder' => 'Введите город']
        ])
            ->add('city_from_code', 'hidden')
            ->add('city_to', 'text', [
                'label' => 'В:',
                'mapped' => false,
                'attr' => ['placeholder' => 'Введите город']
            ])
            ->add('city_to_code', 'hidden')
            ->add('date_from', 'text', [
                'label' => 'Дата вылета:',
                'attr' => ['placeholder' => 'Укажите дату']
            ])
            ->add('date_to', 'text', [
                'label' => 'Дата прилёта:',
                'attr' => ['placeholder' => 'Укажите дату'],
                'required' => false,
                'data' => 0
            ])
            ->add('return_way','choice',[

                'choices' => ['В одну сторону','В обе стороны'],
                'data' => 0,
                'multiple' => false,
                'expanded' => true,
                'required' => true,
            ])
            ->add('adults', 'choice', [

                'label' => 'Взрослых (12+ лет):',
                'choices' => $adults
            ])
            ->add('children', 'choice', [
                'label' => 'Детей (2...<12 лет):',
                'choices' => $children
            ])
            ->add('infant', 'choice', [
                'label' => 'Младенцев:',
                'choices' => $infant
            ])
            ->add('class', 'choice', [
                'label' => 'Класс:',
                'choices' => [
                'Y' => 'Эконом',
                'C' => 'Бизнес',
                'F' => 'Первый',
            ]])
            ->add('avia_company', 'choice', [
                'label' => 'Авиакомпания:',
                'choices' => $this->getAviaCompany()
            ])
            ->add('currency', 'choice', [
                'label' => 'Валюта:',
                'choices' => ['usd' => 'USD', 'uah' => 'UAH', 'eur' => 'EUR']
            ])
            ->add('best_price', 'checkbox', [
                'label' => 'Лучшая цена ±3 дня:',
                'required' => false
            ])
            ->add('direct_flights', 'checkbox', [
                'label' => 'Только прямые рейсы:',
                'required' => false,
            ]);



    }

    protected function getAviaCompany()
    {
        return [
            "all" => "любая",
            "NH" => "ANA All Nippon Airways (NH)",
            "TZ" => "ATA Airlines Inc (TZ)",
            "JP" => "Adria Airways (JP)",
            "A3" => "Aegean Aviation (A3)",
            "RE" => "Aer Arann (RE)",
            "EI" => "Aerlingus (EI)",
            "EE" => "Aero Airlines (EE)",
            "SU" => "Aeroflot (SU)",
            "AR" => "Aerolineas Argentinas (AR)",
            "2K" => "Aerolineas Galapagos (2K)",
            "N2" => "Aerolineas Internacional (N2)",
            "VW" => "Aeromar (VW)",
            "AM" => "Aeromexico (AM)",
            "VH" => "Aeropostal (VH)",
            "5L" => "Aerosur (5L)",
            "VV" => "Aerosvit Airlines (VV)",
            "8U" => "Afriqiyah Airways (8U)",
            "AH" => "Air Algerie (AH)",
            "A6" => "Air Alps Aviation (A6)",
            "5C" => "Air Astana (5C)",
            "KC" => "Air Astana (KC)",
            "UU" => "Air Austral (UU)",
            "AB" => "Air Berlin (AB)",
            "JA" => "Air Bosna (JA)",
            "BP" => "Air Botswana Corp (BP)",
            "2J" => "Air Burkina (2J)",
            "AC" => "Air Canada (AC)",
            "CA" => "Air China (CA)",
            "EN" => "Air Dolomiti (EN)",
            "UX" => "Air Europa (UX)",
            "AF" => "Air France (AF)",
            "VU" => "Air Ivoire (VU)",
            "JM" => "Air Jamaica (JM)",
            "LT" => "Air Lituanica (LT)",
            "LK" => "Air Luxor (LK)",
            "L8" => "Air Luxor GB (L8)",
            "C2" => "Air Luxor STP (C2)",
            "NX" => "Air Macau (NX)",
            "MD" => "Air Madagascar (MD)",
            "QM" => "Air Malawi (QM)",
            "KM" => "Air Malta (KM)",
            "MK" => "Air Mauritius (MK)",
            "9U" => "Air Moldova (9U)",
            "SW" => "Air Namibia (SW)",
            "NZ" => "Air New Zealand (NZ)",
            "PX" => "Air Niugini (PX)",
            "AP" => "Air One (AP)",
            "FJ" => "Air Pacific (FJ)",
            "A7" => "Air Plus Comet (A7)",
            "HM" => "Air Seychelles (HM)",
            "TN" => "Air Tahiti Nui (TN)",
            "TC" => "Air Tanzania (TC)",
            "U7" => "Air Uganda (U7)",
            "NF" => "Air Vanuatu (NF)",
            "QC" => "Air Zaire (QC)",
            "BT" => "AirBaltic (BT)",
            "2L" => "Airblue (2L)",
            "SB" => "Aircalin (SB)",
            "A5" => "Airlinair (A5)",
            "AS" => "Alaska Airlines (AS)",
            "AZ" => "Alitalia (AZ)",
            "AA" => "American Airlines (AA)",
            "WK" => "American Falcon (WK)",
            "IZ" => "Arkia (IZ)",
            "U8" => "Armavia (U8)",
            "R7" => "Aserca (R7)",
            "OZ" => "Asiana Airlines (OZ)",
            "7B" => "Atlant-Soyuz (7B)",
            "RC" => "Atlantic Airways (RC)",
            "TD" => "Atlantis European Airways (TD)",
            "KK" => "Atlasjet Airlines (KK)",
            "OS" => "Austrian Airlines (OS)",
            "6A" => "Aviacsa (6A)",
            "AV" => "Avianca (AV)",
            "GU" => "Aviateca (GU)",
            "J2" => "Azerbaijan Airlines (J2)",
            "BD" => "BMI British Midland (BD)",
            "UP" => "Bahamasair (UP)",
            "PG" => "Bangkok Airways (PG)",
            "4T" => "Belair Airlines (4T)",
            "B2" => "Belavia (B2)",
            "J8" => "Berjaya Air (J8)",
            "B4" => "Bhoja Airlines Ltd (B4)",
            "BG" => "Biman Bangladesh Airline (BG)",
            "NT" => "Binter Canarias (NT)",
            "KF" => "Blue1 (KF)",
            "WW" => "Bmibaby (WW)",
            "9H" => "Bonair Exel (9H)",
            "BA" => "British Airways (BA)",
            "SN" => "Brussels Airlines (SN)",
            "FB" => "Bulgaria Air (FB)",
            "XK" => "CCM (XK)",
            "W2" => "Canadian Western Airlines (W2)",
            "9K" => "Cape Air (9K)",
            "BW" => "Caribbean Airways (BW)",
            "8B" => "Caribbean Star Airlines (8B)",
            "V3" => "Carpatair (V3)",
            "CX" => "Cathay Pacific (CX)",
            "KX" => "Cayman Airways Ltd (KX)",
            "9M" => "Central Mountain Air (9M)",
            "CI" => "China Airlines (CI)",
            "MU" => "China Eastern Airlines (MU)",
            "CZ" => "China Southern Airlines (CZ)",
            "QI" => "Cimber Air (QI)",
            "C9" => "Cirrus Airlines (C9)",
            "DE" => "Condor (DE)",
            "CO" => "Continental Airlines (CO)",
            "V0" => "Conviasa (V0)",
            "CM" => "Copa Air (CM)",
            "SS" => "Corsair (SS)",
            "OR" => "Crimea Air (OR)",
            "OU" => "Croatia Airlines (OU)",
            "CU" => "Cubana de Aviaciуn (CU)",
            "CY" => "Cyprus Airways (CY)",
            "OK" => "Czech Airlines (OK)",
            "DI" => "DBA (DI)",
            "H8" => "Dalavia (H8)",
            "DX" => "Danish Air Transport (DX)",
            "0D" => "Darwin Airline (0D)",
            "DL" => "Delta Air Lines (DL)",
            "9B" => "Deutsche Bahn AG (9B)",
            "Z6" => "Dnieproavia (Z6)",
            "E3" => "Domodedovo Airlines (E3)",
            "7D" => "Donbassaero (7D)",
            "KA" => "Dragonair (KA)",
            "YR" => "Eagle Canyon Airlines (YR)",
            "T3" => "Eastern Airways (T3)",
            "MS" => "Egyptair (MS)",
            "LY" => "El Al Israel Airlines (LY)",
            "EK" => "Emirates (EK)",
            "OV" => "Estonian Air (OV)",
            "ET" => "Ethiopian Airlines (ET)",
            "EY" => "Etihad Airways (EY)",
            "K2" => "EuroLOT (K2)",
            "9F" => "Eurostar (9F)",
            "BR" => "Eva Air (BR)",
            "AY" => "Finnair (AY)",
            "FC" => "Finncomm (FC)",
            "BE" => "FlyBE (BE)",
            "F7" => "Flybaboo (F7)",
            "F9" => "Frontier Airlines (F9)",
            "Z5" => "GMG Airlines (Z5)",
            "GA" => "Garuda Indonesia (GA)",
            "A9" => "Georgian Airways (A9)",
            "4U" => "Germanwings (4U)",
            "G3" => "Gol Airlines (G3)",
            "DC" => "Golden Air (DC)",
            "GF" => "Gulf Air (GF)",
            "GY" => "Guyana Airways (GY)",
            "HR" => "Hahn Air (HR)",
            "HU" => "Hainan Airlines (HU)",
            "4R" => "Hamburg International (4R)",
            "HA" => "Hawaiian Airlines (HA)",
            "YO" => "Heli Air Monaco (YO)",
            "EO" => "Hewa Bora Airways (EO)",
            "HX" => "Hong Kong Airlines (HX)",
            "UO" => "Hong Kong Express Airways (UO)",
            "IB" => "Iberia (IB)",
            "FI" => "Icelandair (FI)",
            "IK" => "Imair Airline (IK)",
            "D6" => "Inter Air (D6)",
            "ID" => "Interlink Airlines (ID)",
            "3L" => "Intersky Luftfahrt (3L)",
            "IO" => "IrAero (IO)",
            "IR" => "Iran Air (IR)",
            "6H" => "Israir Airlines (6H)",
            "GI" => "Itek Air (GI)",
            "D9" => "JSC Donavia (D9)",
            "5N" => "JSC Nordavia (5N)",
            "JO" => "Jalways (JO)",
            "JL" => "Japan Airlines (JL)",
            "JU" => "Jat Airways (JU)",
            "9W" => "Jet Airways (9W)",
            "S2" => "Jet Lite (S2)",
            "LS" => "Jet2.Com (LS)",
            "8J" => "Jet4you.Com (8J)",
            "B6" => "Jetblue Airways (B6)",
            "J0" => "Jetlink Express (J0)",
            "JQ" => "Jetstar Airways (JQ)",
            "3B" => "Job Air (3B)",
            "KL" => "KLM Royal Dutch Airlines (KL)",
            "KV" => "Kavminvodyavia Airlines (KV)",
            "KD" => "Kendell Airlines (KD)",
            "KQ" => "Kenya Airways (KQ)",
            "IT" => "Kingfisher Airlines (IT)",
            "7K" => "Kogalymavia (7K)",
            "KE" => "Korean Air (KE)",
            "KU" => "Kuwait Airways (KU)",
            "TM" => "LAM Mozambique (TM)",
            "LA" => "LAN Airlines (LA)",
            "LO" => "LOT Polish Airlines (LO)",
            "LR" => "Lacsa (LR)",
            "4M" => "Lanargentina (4M)",
            "XL" => "Lanecuador Aerolane SA (XL)",
            "LP" => "Lanperu (LP)",
            "QV" => "Lao Aviation (QV)",
            "LI" => "Liat (LI)",
            "LN" => "Libyan Airlines (LN)",
            "LH" => "Lufthansa (LH)",
            "CL" => "Lufthasa CityLine (CL)",
            "LG" => "Luxair (LG)",
            "W5" => "Mahan Airlines (W5)",
            "MH" => "Malaysia Airlines (MH)",
            "TF" => "Malmo Aviation (TF)",
            "MA" => "Malév Hungarian Airlines (MA)",
            "AE" => "Mandarin Airlines (AE)",
            "MP" => "Martinair Holland (MP)",
            "YD" => "Mauritania Airways (YD)",
            "MW" => "Maya Airways (MW)",
            "IG" => "Meridiana (IG)",
            "MX" => "Mexicana de Aviacion (MX)",
            "OM" => "Miat-Mongolian Airlines (OM)",
            "ME" => "Middle East Airlines (ME)",
            "YX" => "Midwest Airlines (YX)",
            "2M" => "Moldavian Airlines (2M)",
            "ZB" => "Monarch Airlines (ZB)",
            "YM" => "Montenegro Airlines (YM)",
            "M9" => "Motor-Sich JSC (M9)",
            "8M" => "Myanmar Airways Int'l (8M)",
            "P9" => "NAS Air (P9)",
            "AI" => "Nacil Air India (AI)",
            "IC" => "Nacil Indian Airline (IC)",
            "RA" => "Nepal Airlines (RA)",
            "2N" => "Nextjet (2N)",
            "HG" => "Niki (HG)",
            "Y7" => "NordStar (Y7)",
            "NW" => "Northwest Airlines (NW)",
            "5K" => "Odessa Airlines (5K)",
            "OL" => "Olt Ostfriesische Lufttr (OL)",
            "OA" => "Olympic Airlines (OA)",
            "WY" => "Oman Air (WY)",
            "LW" => "Pacific Wings (LW)",
            "PC" => "Pegasus Airlines (PC)",
            "7V" => "Pelican Air (7V)",
            "9G" => "Perm Airlines (9G)",
            "PR" => "Philippine Airlines (PR)",
            "PU" => "Pluna (PU)",
            "YQ" => "Polet Airlines (YQ)",
            "NI" => "Portugalia (NI)",
            "PW" => "Precision Air (PW)",
            "QF" => "Qantas Airways (QF)",
            "QR" => "Qatar Airways (QR)",
            "AT" => "Royal Air Maroc (AT)",
            "BI" => "Royal Brunei (BI)",
            "RJ" => "Royal Jordanian Airline (RJ)",
            "WR" => "Royal Tongan Airlines (WR)",
            "7R" => "Rusline (7R)",
            "FV" => "Russian Airlines (FV)",
            "WB" => "Rwandair Express (WB)",
            "S7" => "S7 Airlines (S7)",
            "HZ" => "SAT Airlines (HZ)",
            "4Q" => "Safi Airways (4Q)",
            "Q3" => "Sandaun Air Services (Q3)",
            "S3" => "Santa Barbara Airlines (S3)",
            "SP" => "Sata Air Acores (SP)",
            "S4" => "Sata International (S4)",
            "SV" => "Saudi Arabian Airlines (SV)",
            "SK" => "Scandinavian Airlines (SK)",
            "DV" => "Scat Air (DV)",
            "K5" => "Seaport/Wings Of Alaska (K5)",
            "UG" => "Sevenair (UG)",
            "D2" => "Severstal Aircompany (D2)",
            "SC" => "Shandong Airlines (SC)",
            "FM" => "Shanghai Airlines (FM)",
            "ZH" => "Shenzhen Airlines (ZH)",
            "3U" => "Sichuan Airlines (3U)",
            "FT" => "Siem Reap Airways Intl (FT)",
            "MI" => "Silkair (MI)",
            "SQ" => "Singapore Airlines (SQ)",
            "7J" => "Skagway Air Services (7J)",
            "H2" => "Sky Airline (H2)",
            "NE" => "Skyeurope Airlines (NE)",
            "XR" => "Skywest Airlines (XR)",
            "LL" => "Small Planet (LL)",
            "QS" => "Smart Wings (QS)",
            "I5" => "Sn Air Mali (I5)",
            "MM" => "Soc Aero de Medellin (MM)",
            "IE" => "Solomon Airlines (IE)",
            "4J" => "Somon Air (4J)",
            "SA" => "South African Airways (SA)",
            "YG" => "South Airlines (YG)",
            "JK" => "Spanair (JK)",
            "UL" => "Srilankan Airlines (UL)",
            "1T" => "Start (1T)",
            "SY" => "Sun Country (SY)",
            "XQ" => "Sun Express (XQ)",
            "PY" => "Surinam Airways (PY)",
            "LX" => "Swiss (LX)",
            "7E" => "Sylt Air (7E)",
            "RB" => "Syrian Arab Airlines (RB)",
            "VR" => "TACV Cabo Verde Airlines (VR)",
            "JJ" => "TAM Airlines (JJ)",
            "TP" => "TAP Air (TP)",
            "DT" => "Taag (DT)",
            "TA" => "Taca Intl Airlines (TA)",
            "PZ" => "Tam Mercosur (PZ)",
            "RO" => "Tarom (RO)",
            "U9" => "Tatarstan Air (U9)",
            "TG" => "Thai Airways Intl (TG)",
            "MT" => "Thomas Cook Airlines (MT)",
            "TW" => "Trans World Airlines (TW)",
            "UN" => "Transaero Airlines (UN)",
            "GE" => "Transasia Airways (GE)",
            "HV" => "Transavia Airlines (HV)",
            "X3" => "Tuifly (X3)",
            "TU" => "Tunisair (TU)",
            "TK" => "Turkish Airlines (TK)",
            "VO" => "Tyrolean Airways (VO)",
            "US" => "US Airways (US)",
            "PS" => "Ukraine International Airlines (PS)",
            "B7" => "Uni Airways (B7)",
            "UA" => "United Airlines (UA)",
            "U6" => "Ural Airlines (U6)",
            "UT" => "Utair Aviation (UT)",
            "QU" => "Utair Ukraine (QU)",
            "HY" => "Uzbekistan Airways (HY)",
            "VA" => "V Australia (VA)",
            "NN" => "VIM Airlines (NN)",
            "VG" => "VLM Airlines (VG)",
            "VN" => "Vietnam Airlines (VN)",
            "VS" => "Virgin Atlantic (VS)",
            "DJ" => "Virgin Blue (DJ)",
            "VK" => "Virgin Nigeria (VK)",
            "XF" => "Vladivostok Air (XF)",
            "VE" => "Volareweb.com (VE)",
            "VY" => "Vueling (VY)",
            "KW" => "Wataniya Airways (KW)",
            "2W" => "Welcome Air (2W)",
            "WS" => "Westjet (WS)",
            "WF" => "Wideroe (WF)",
            "7W" => "Wind Rose Aviation (7W)",
            "WM" => "Windward Island Airways (WM)",
            "MF" => "Xiamen Airlines (MF)",
            "SE" => "Xl Airways France (SE)",
            "R3" => "Yakutia Air Company (R3)",
            "YC" => "Yamal Airlines (YC)",
            "IY" => "Yemenia Yemen Airways (IY)",
            "ZJ" => "Zambezi Airlines (ZJ)",
        ];
    }

    public function getName()
    {
        return 'SearchForm';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));
    }

} 