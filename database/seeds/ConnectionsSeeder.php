<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ConnectionsSeeder extends Seeder
{

    private $emails = ["bmactague0@dell.com",
"qivchenko1@kickstarter.com",
"bchidzoy2@dagondesign.com",
"btrousdale3@sitemeter.com",
"iniesegen4@cyberchimps.com",
"myitzhok5@baidu.com",
"bgrivori6@seattletimes.com",
"dadamovich7@ed.gov",
"cbirkwood8@ucoz.ru",
"ctuckley9@admin.ch",
"rdancera@howstuffworks.com",
"bstannardb@craigslist.org",
"spotapczukc@mozilla.com",
"dtelfordd@flavors.me",
"iwyche@twitter.com",
"ljeacockf@sina.com.cn",
"hcahang@feedburner.com",
"tmedfordh@yellowpages.com",
"hlevinsi@narod.ru",
"crebillardj@delicious.com",
"ablackborok@redcross.org",
"bjumpl@columbia.edu",
"lreddlem@thetimes.co.uk",
"teynaudn@altervista.org",
"jraddano@cocolog-nifty.com",
"klauchlanp@w3.org",
"mokeevanq@answers.com",
"ddentyr@hhs.gov",
"mbaudones@mozilla.com",
"mwiskart@ask.com",
"lcartmanu@technorati.com",
"acapstackv@desdev.cn",
"fjerrimw@drupal.org",
"wloveridgex@1und1.de",
"gfouldsy@answers.com",
"cbrameldz@tripod.com",
"gbourley10@ucoz.ru",
"bhandrek11@e-recht24.de",
"lkissell12@indiatimes.com",
"rgatchel13@wufoo.com",
"ltoplin14@smh.com.au",
"kmalzard15@i2i.jp",
"opowling16@eepurl.com",
"lcolleymore17@posterous.com",
"kbeaglehole18@clickbank.net",
"chockey19@amazon.de",
"hdregan1a@yahoo.co.jp",
"janscombe1b@foxnews.com",
"pcoppo1c@pen.io",
"bemanuelov1d@google.it",
"troseman1e@intel.com",
"dtaunton1f@baidu.com",
"bbaptie1g@alibaba.com",
"echitson1h@unicef.org",
"gcaldow1i@google.com.au",
"jkatt1j@sogou.com",
"nmaryon1k@123-reg.co.uk",
"lhudless1l@shinystat.com",
"cpedlow1m@php.net",
"hdrakes1n@berkeley.edu",
"nomeara1o@chronoengine.com",
"mfieldgate1p@gnu.org",
"cscard1q@lulu.com",
"mmitchard1r@nsw.gov.au",
"olethbrig1s@squarespace.com",
"ewhyberd1t@tinypic.com",
"wdietsche1u@tmall.com",
"mhoxey1v@dell.com",
"itomala1w@businessinsider.com",
"gswyn1x@nhs.uk",
"ebrownlie1y@altervista.org",
"mkimmerling1z@reverbnation.com",
"vrannigan20@hao123.com",
"fcookes21@sogou.com",
"jjedrzejewsky22@1und1.de",
"lokynsillaghe23@studiopress.com",
"lbrannan24@hubpages.com",
"cshawcroft25@wiley.com",
"dbarcroft26@blog.com",
"lgiorgi27@loc.gov",
"lreadwin28@reddit.com",
"mskains29@mac.com",
"ldjakovic2a@guardian.co.uk",
"acenter2b@myspace.com",
"abearman2c@hostgator.com",
"ewalton2d@odnoklassniki.ru",
"ddemullett2e@example.com",
"bdetoile2f@tripod.com",
"iturbern2g@linkedin.com",
"mantonich2h@arizona.edu",
"oryman2i@ihg.com",
"bcollishaw2j@deliciousdays.com",
"mosband2k@jalbum.net",
"mpayn2l@blogtalkradio.com",
"ahuyghe2m@plala.or.jp",
"scatanheira2n@lulu.com",
"oriddett2o@fastcompany.com",
"mheakey2p@geocities.com",
"jcarl2q@fastcompany.com",
"ctrinke2r@hubpages.com"];
    
    private $phones = [
        "+380 (732) 999-0048",
"+48 (519) 321-7279",
"+387 (270) 843-8800",
"+86 (455) 795-2849",
"+86 (390) 235-1354",
"+62 (598) 758-2554",
"+850 (473) 219-6560",
"+33 (845) 271-9119",
"+48 (747) 688-0148",
"+63 (687) 433-2594",
"+229 (931) 262-3848",
"+86 (589) 392-9125",
"+229 (858) 140-7227",
"+48 (445) 942-9986",
"+380 (852) 155-2337",
"+48 (577) 662-1228",
"+353 (794) 820-7130",
"+7 (620) 656-9367",
"+995 (435) 258-0534",
"+7 (782) 711-3182",
"+62 (984) 722-8154",
"+86 (102) 486-0262",
"+48 (255) 822-9113",
"+62 (860) 383-0353",
"+380 (839) 981-2432",
"+1 (573) 385-7615",
"+54 (169) 608-0905",
"+872 (265) 610-0816",
"+7 (286) 621-0743",
"+63 (990) 372-9212",
"+55 (572) 344-0583",
"+58 (815) 788-9797",
"+48 (621) 242-0941",
"+86 (418) 878-9224",
"+48 (137) 373-6369",
"+886 (405) 946-2155",
"+55 (566) 395-5681",
"+380 (854) 304-7409",
"+62 (995) 338-1042",
"+52 (795) 457-1933",
"+503 (701) 567-9416",
"+43 (215) 796-5700",
"+7 (870) 444-7882",
"+86 (838) 231-8150",
"+81 (958) 620-8144",
"+7 (622) 318-7050",
"+86 (911) 378-4956",
"+86 (952) 823-0911",
"+46 (649) 215-8192",
"+420 (165) 935-2674",
"+355 (576) 286-1408",
"+7 (750) 264-1176",
"+970 (425) 365-0259",
"+380 (966) 495-4821",
"+351 (316) 476-2950",
"+54 (280) 243-4805",
"+51 (585) 510-7099",
"+30 (220) 253-4563",
"+20 (378) 386-1966",
"+961 (440) 174-1937",
"+351 (945) 159-6255",
"+221 (345) 807-8745",
"+84 (323) 964-1346",
"+86 (510) 942-4945",
"+58 (741) 693-4167",
"+86 (810) 831-7431",
"+45 (513) 942-1653",
"+357 (444) 558-2030",
"+1 (502) 229-0739",
"+81 (742) 624-1235",
"+55 (976) 744-8726",
"+7 (941) 439-4028",
"+63 (604) 253-1920",
"+7 (818) 437-0451",
"+62 (148) 530-7064",
"+86 (933) 914-4079",
"+62 (891) 450-9707",
"+1 (826) 951-5339",
"+251 (618) 206-1132",
"+62 (900) 777-8126",
"+55 (425) 488-7736",
"+33 (355) 477-3220",
"+54 (236) 950-1665",
"+62 (173) 267-5016",
"+1 (100) 972-5426",
"+33 (555) 409-8553",
"+62 (934) 552-6785",
"+46 (984) 668-8533",
"+225 (779) 884-0482",
"+81 (661) 662-2688",
"+230 (364) 469-3969",
"+260 (690) 748-8348",
"+237 (155) 792-3605",
"+420 (711) 688-3470",
"+216 (101) 300-9060",
"+86 (472) 647-9304",
"+30 (434) 669-1711",
"+966 (230) 805-6730",
"+95 (446) 518-5796",
"+234 (261) 302-3540"
    ];
    
    private $urls = [
        "http://mozilla.com",
"https://mayoclinic.com",
"https://pagesperso-orange.fr",
"http://bluehost.com",
"https://behance.net",
"https://omniture.com",
"http://printfriendly.com",
"http://ftc.gov",
"http://cornell.edu",
"http://bloglines.com",
"http://dell.com",
"http://ibm.com",
"https://dagondesign.com",
"http://theatlantic.com",
"https://princeton.edu",
"http://opera.com",
"http://globo.com",
"https://bigcartel.com",
"https://ameblo.jp",
"http://nih.gov",
"http://issuu.com",
"http://sohu.com",
"https://nasa.gov",
"https://wix.com",
"http://networkadvertising.org",
"http://msn.com",
"https://drupal.org",
"http://nps.gov",
"http://wikimedia.org",
"https://meetup.com",
"http://npr.org",
"https://marketwatch.com",
"https://blogtalkradio.com",
"https://discuz.net",
"https://biblegateway.com",
"http://goodreads.com",
"http://gnu.org",
"https://e-recht24.de",
"http://usa.gov",
"https://ihg.com",
"https://dagondesign.com",
"https://about.com",
"https://nsw.gov.au",
"http://bloglines.com",
"https://xinhuanet.com",
"https://fda.gov",
"https://spotify.com",
"http://statcounter.com",
"http://nyu.edu",
"https://wsj.com",
"https://google.com",
"https://shop-pro.jp",
"https://ebay.co.uk",
"http://yahoo.co.jp",
"https://elegantthemes.com",
"https://hibu.com",
"https://elpais.com",
"https://posterous.com",
"http://nsw.gov.au",
"http://epa.gov",
"http://webmd.com",
"https://scientificamerican.com",
"http://mozilla.org",
"https://buzzfeed.com",
"https://wisc.edu",
"http://surveymonkey.com",
"https://liveinternet.ru",
"https://mtv.com",
"https://dropbox.com",
"http://weibo.com",
"https://dot.gov",
"http://cpanel.net",
"https://netvibes.com",
"https://va.gov",
"https://fotki.com",
"https://smh.com.au",
"http://google.pl",
"http://sourceforge.net",
"http://nytimes.com",
"https://e-recht24.de",
"http://usnews.com",
"https://wikia.com",
"https://nifty.com",
"http://reddit.com",
"http://stumbleupon.com",
"https://uol.com.br",
"https://deviantart.com",
"http://alexa.com",
"https://sourceforge.net",
"https://nps.gov",
"http://google.com",
"http://barnesandnoble.com",
"http://weather.com",
"http://vimeo.com",
"https://twitpic.com",
"https://epa.gov",
"https://wikia.com",
"http://netscape.com",
"https://washingtonpost.com",
"https://netlog.com"
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();
        foreach ($this->emails as $email) {
            DB::table('connections')->insert([
                'connectiontype_id' => 1,
                'data' => $email,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
        foreach ($this->phones as $url) {
            DB::table('connections')->insert([
                'connectiontype_id' => rand(2, 3),
                'data' => $url,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
        foreach ($this->urls as $url) {
            DB::table('connections')->insert([
                'connectiontype_id' => 4,
                'data' => $url,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
        $contacts = \App\Model\Contact::all();
        $connections = \App\Model\Connection::all();
        $i = 1;
        foreach ($contacts as $contact) {
            $contact->connections()->attach($connections[$i++]);
            if (rand(1, 2) == 1) {
                $contact->connections()->attach($connections[$i++]);
            }
            if (rand(1, 3) == 1) {
                $contact->connections()->attach($connections[$i++]);
            }
            if (rand(1, 4) == 1) {
                $contact->connections()->attach($connections[$i++]);
            }
            if ($i > 297 ) $i = 1;
        }
        $addresses = \App\Model\Address::all();
        $i = 1;
        foreach ($addresses as $address) {
            $address->connections()->attach($connections[$i++]);
            if (rand(1, 2) == 1) {
                $address->connections()->attach($connections[$i++]);
            }
            if (rand(1, 3) == 1) {
                $address->connections()->attach($connections[$i++]);
            }
            if (rand(1, 4) == 1) {
                $address->connections()->attach($connections[$i++]);
            }
            if ($i > 297 ) $i = 1;
        }
    }
}
