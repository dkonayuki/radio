<?php
/**
 * Created by Khatcher Holmes
 * Date: 9/27/15 7:03 PM
 */

namespace App\ApiBatch;

/**
 * Retrieves data from Radio.jp API (ref: http://www.dcc-jpl.com/foltia/wiki/radikomemo)
 * Class ApiBatchRadiko
 * @package App
 */
class ApiBatchRadiko extends ApiBatchBase
{
    const API_CATEGORY_ID = 1;
    const BASE_URL = "http://radiko.jp/v2/";

    function __construct()
    {
        parent::__construct('ApiBatchRadiko');
    }

    /**
     * Function that returns list of programs for given radio for today
     * @param int $radio_id Radio ID
     * @return mixed Request result
     */
    public function getPrograms($radio_id)
    {
        $this->setUrl(ApiBatchRadiko::BASE_URL)
            ->setMethod(ApiBatchBase::METHOD_GET)
            ->setTarget('api/program/station/today')
            ->setParams(array('station_id' => $radio_id));

        $res = null;
        try {
            $res = $this->execute();
        } catch (\Exception $ex) {
            echo "Radiko API call failed for station: [$radio_id] " . ", Err: " . $ex->getMessage(); // TODO: remove echoes
            \Log::alert("Radiko API call failed for station: [$radio_id] " . ", Err: " . $ex->getMessage());
        }

        // parse XML result
        var_dump($res); exit;
        // TODO: parse images from result
    }

    public function populateRadios()
    {
        foreach ($this->area_list as $key => $val) {
            $this->setUrl(ApiBatchRadiko::BASE_URL)
                ->setMethod(ApiBatchBase::METHOD_GET)
                ->setTarget('station/list/' . $key . '.xml');

            $res = null;
            try {
                $res = $this->execute();
            } catch (\Exception $ex) {
                echo "Radiko API call failed for area: [$key] " . $val . ", Err: " . $ex->getMessage(); // TODO: remove echoes
                \Log::alert("Radiko API call failed for area: [$key] " . $val . ", Err: " . $ex->getMessage());
            }

            // parse XML result
            var_dump($res); exit;
            // TODO: get logos for each station
        }
    }


    /**
     * in Radiko program information is given separately for each region of Japan.
     * TODO: uncomment remaining regions (commented for faster testing)
     * @var array $area_list
     */
    private $area_list = array(
        'JP1' => 'HOKKAIDO JAPAN',
        'JP2' => 'AOMORI JAPAN',
        'JP3' => 'IWATE JAPAN'/*,
        'JP4' => 'MIYAGI JAPAN',
        'JP5' => 'AKITA JAPAN',
        'JP6' => 'YAMAGATA JAPAN',
        'JP7' => 'FUKUSHIMA JAPAN',
        'JP8' => 'IBARAKI JAPAN',
        'JP9' => 'TOCHIGI JAPAN',
        'JP10' => 'GUNMA JAPAN',
        'JP11' => 'SAITAMA JAPAN',
        'JP12' => 'CHIBA JAPAN',
        'JP13' => 'TOKYO JAPAN',
        'JP14' => 'KANAGAWA JAPAN',
        'JP15' => 'NIIGATA JAPAN',
        'JP16' => 'TOYAMA JAPAN',
        'JP17' => 'ISHIKAWA JAPAN',
        'JP18' => 'FUKUI JAPAN',
        'JP19' => 'YAMANASHI JAPAN',
        'JP20' => 'NAGANO JAPAN',
        'JP21' => 'GIFU JAPAN',
        'JP22' => 'SHIZUOKA JAPAN',
        'JP23' => 'AICHI JAPAN',
        'JP24' => 'MIE JAPAN',
        'JP25' => 'SHIGA JAPAN',
        'JP26' => 'KYOTO JAPAN',
        'JP27' => 'OSAKA JAPAN',
        'JP28' => 'HYOGO JAPAN',
        'JP29' => 'NARA JAPAN',
        'JP30' => 'WAKAYAMA JAPAN',
        'JP31' => 'TOTTORI JAPAN',
        'JP32' => 'SHIMANE JAPAN',
        'JP33' => 'OKAYAMA JAPAN',
        'JP34' => 'HIROSHIMA JAPAN',
        'JP35' => 'YAMAGUCHI JAPAN',
        'JP36' => 'TOKUSHIMA JAPAN',
        'JP37' => 'KAGAWA JAPAN',
        'JP38' => 'EHIME JAPAN',
        'JP39' => 'KOUCHI JAPAN',
        'JP40' => 'FUKUOKA JAPAN',
        'JP41' => 'SAGA JAPAN',
        'JP42' => 'NAGASAKI JAPAN',
        'JP43' => 'KUMAMOTO JAPAN',
        'JP44' => 'OHITA JAPAN',
        'JP45' => 'MIYAZAKI JAPAN',
        'JP46' => 'KAGOSHIMA JAPAN',
        'JP47' => 'OKINAWA JAPAN'*/
    );

   /*
    * Sample response for program list before parsing
    *
<radiko>
  <ttl>1800</ttl>
  <srvtime>1443349509</srvtime>
  <stations>
   <station id="FMJ">
      <name>J-WAVE</name>
      <scd>
        <progs>
          <date>20150927</date>
          <prog ft="20150927050000" to="20150927060000" ftl="0500" tol="0600" dur="3600">
            <title>朝ドレ情報いちばん</title>
            <sub_title />  <pfm>田中雄介/江藤愛/岡本綾子</pfm>
            <desc />  <info>&lt;img src=&apos;http://www.tbs.co.jp/radio/todays954/photo/tanaka_yuusuke.jpg&apos;&gt;&lt;
   br /&gt;&lt;br /&gt;メール：&lt;a href=&quot;mailto:asadore@tbs.co.jp&quot;&gt;asadore@tbs.co.jp&lt;/a&gt;&lt;br/&gt;</info>
            <metas>
              <meta name="twitter" value="#radiko" />
              <meta name="twitter-hash" value="#radiko" />
              <meta name="facebook-fanpage" value="http://www.facebook.com/radiko.jp" />
            </metas>
            <url>http://www.tbs.co.jp/radio/asadore/</url>
          </prog>

		  <!-- other <prog>s -->
        </progs>
      </scd>
    </station>
    <!-- other <station>s -->
  </stations>
</radiko>

   Sample response for stations list
<stations area_id="JP13" area_name="TOKYO JAPAN">
  <station>
    <id>TBS</id>
    <name>TBSラジオ</name>
    <ascii_name>TBS RADIO</ascii_name>
    <href>http://www.tbs.co.jp/radio/</href>
    <logo_xsmall>http://radiko.jp/station/logo/TBS/logo_xsmall.png</logo_xsmall>
    <logo_small>http://radiko.jp/station/logo/TBS/logo_small.png</logo_small>
    <logo_medium>http://radiko.jp/station/logo/TBS/logo_medium.png</logo_medium>
    <logo_large>http://radiko.jp/station/logo/TBS/logo_large.png</logo_large>
    <logo width="124" height="40">http://radiko.jp/v2/static/station/logo/TBS/124x40.png</logo>
    <logo width="344" height="80">http://radiko.jp/v2/static/station/logo/TBS/344x80.png</logo>
    <logo width="688" height="160">http://radiko.jp/v2/static/station/logo/TBS/688x160.png</logo>
    <logo width="172" height="40">http://radiko.jp/v2/static/station/logo/TBS/172x40.png</logo>
    <logo width="224" height="100">http://radiko.jp/v2/static/station/logo/TBS/224x100.png</logo>
    <logo width="448" height="200">http://radiko.jp/v2/static/station/logo/TBS/448x200.png</logo>
    <logo width="112" height="50">http://radiko.jp/v2/static/station/logo/TBS/112x50.png</logo>
    <logo width="168" height="75">http://radiko.jp/v2/static/station/logo/TBS/168x75.png</logo>
    <logo width="258" height="60">http://radiko.jp/v2/static/station/logo/TBS/258x60.png</logo>
    <feed>http://radiko.jp/station/feed/TBS.xml</feed>
    <banner>http://radiko.jp/res/banner/TBS/20130329155819.jpg</banner>
  </station>
    <!-- other <station>s -->
</stations>
    * */
}