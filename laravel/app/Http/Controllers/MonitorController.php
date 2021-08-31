<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Blokirkade;

class MonitorController extends Controller
{
    public function proses(Request $request)
    {

        $from = $request->date_start;
        $to = $request->date_end;

        $dataIntern= DB::select($this->getSql('I', $from, $to));
        $dataDomes= DB::select($this->getSql('D', $from, $to));
        $dataCurah= DB::select($this->getSql('C', $from, $to));
        $data = [
            'Intern' => $dataIntern,
            'Domes' => $dataDomes,
            'Curah' => $dataCurah,
        ];

        return response()->json($data);
    }

    public function proses2(Request $request)
    {

        $from = $request->date2_start;
        $to = $request->date2_end;

        $dataIntern= DB::select($this->getSql('I', $from, $to));
        $dataDomes= DB::select($this->getSql('D', $from, $to));
        $dataCurah= DB::select($this->getSql('C', $from, $to));
        $data = [
            'Intern' => $dataIntern,
            'Domes' => $dataDomes,
            'Curah' => $dataCurah,
        ];

        return response()->json($data);
    }

    private function getSql($ocean_interisland_fake, $from, $to)
    {
        return "SELECT A.VES_ID,
          VES_ID_OLD,
          A.VES_NAME,
          A.VES_CODE,
          A.EST_BERTH_TS,
          A.ACT_BERTH_TS,
          A.EST_DEP_TS,
          A.ACT_DEP_TS,
          A.DISC_ACT,
          A.DISC_PLAN,
          A.DISC_REMAIN,
          A.LOAD_ACT,
          A.LOAD_PLAN,
          A.LOAD_REMAIN,
          A.BOX_ACT,
          A.BOX_PLAN,
          A.BOX_REMAIN,
          A.TIME_REMAIN,
          A.TIME_REMAIN_LABEL,
          A.EST_END_DATE,
          EST_PILOT_TS,
          A.REQ_BERTH_TS,
          EST_ANCHORAGE_TS,
          EST_START_WORK_TS,
          EST_END_WORK_TS,
          DOCO_CUTOFF_TS,
          RECV_CTR_CUTOFF_TS,
          RECV_CARGO_CUTOFF_TS,
          ACT_DEP_TS_ORI,
          A.Y_AKHIR_EST,
          A.BERTH_FR_METRE_ORI,
          A.BERTH_TO_METRE_ORI,
          A.BERTH_FR_METRE,
          A.BERTH_TO_METRE,
          A.WIDTH_ORI,
          A.WIDTH,
          A.Y_AWAL,
          A.Y_AKHIR,
          A.OCEAN_INTERISLAND,
          A.OCEAN_INTERISLAND_FAKE,
          A.HEIGHT,
          A.AGENT,
          A.AGENT_NAME,
          A.AGENT_MOBILE,
          A.IMAGE,
          A.REAL_LOAD,
          A.EST_DISCH,
          A.REAL_DISCH,
          A.BTOA_SIDE,
          A.IS_SIMULATION,
          A.BSH,
          A.BCH,
          A.NEXT_PORT,
          A.DEST_PORT,
          A.EST_LOAD,
          A.EST_DISCHARGE,
          A.INFO,
          A.CRANE,
          A.VES_TYPE,
          A.VES_SERVICE,
          A.WINDOWS,
          A.IN_VOYAGE,
          A.OUT_VOYAGE,
          Y_AKHIR_EST - Y_AWAL HEIGHT_EST,
          TENTATIF,
          IS_UNREG,
          1 IS_INSERTED
     FROM (SELECT A.VES_ID,
                  VES_ID_OLD,
                  A.VES_NAME,
                  A.VES_CODE,
                  A.EST_BERTH_TS,
                  A.ACT_BERTH_TS,
                  A.EST_DEP_TS,
                  A.ACT_DEP_TS,
                  A.EST_PILOT_TS,
                  A.REQ_BERTH_TS,
                  EST_ANCHORAGE_TS,
                  EST_START_WORK_TS,
                  EST_END_WORK_TS,
                  DOCO_CUTOFF_TS,
                  RECV_CTR_CUTOFF_TS,
                  RECV_CARGO_CUTOFF_TS,
                  ACT_DEP_TS_ORI,
                  --          DISC_ACT,
                  --          LOAD_ACT,
                  DISC_ACT,
                  DISC_REMAIN + DISC_ACT DISC_PLAN,
                  DISC_REMAIN,
                  LOAD_ACT,
                  LOAD_REMAIN + LOAD_ACT LOAD_PLAN,
                  LOAD_REMAIN,
                  DISC_ACT + LOAD_ACT BOX_ACT,
                  DISC_REMAIN + DISC_ACT + LOAD_REMAIN + LOAD_ACT BOX_PLAN,
                  DISC_REMAIN + LOAD_REMAIN BOX_REMAIN,
                  CASE
                     WHEN ACT_BERTH_TS < TO_DATE('{$from}', 'YYYY-MM-DD') AND ACT_DEP_TS IS NULL
                     THEN
                        (DISC_REMAIN + LOAD_REMAIN) / BSH
                     ELSE
                        NULL
                  END
                     TIME_REMAIN,
                  CASE
                     WHEN ACT_BERTH_TS < TO_DATE('{$from}', 'YYYY-MM-DD') AND ACT_DEP_TS IS NULL
                     THEN
                        (CASE
                            WHEN ( (DISC_REMAIN + LOAD_REMAIN) / BSH) * 60 <
                                    60
                            THEN
                                  ROUND (
                                       ( (DISC_REMAIN + LOAD_REMAIN) / BSH)
                                     * 60,
                                     0)
                               || ' minute '
                            ELSE
                                  NVL (
                                     FLOOR (
                                        (DISC_REMAIN + LOAD_REMAIN) / BSH),
                                     0)
                               || ' Hour '
                               || NVL (
                                     ROUND (
                                          (  (  (DISC_REMAIN + LOAD_REMAIN)
                                              / BSH)
                                           - FLOOR (
                                                (  (DISC_REMAIN + LOAD_REMAIN)
                                                 / BSH)))
                                        * 60),
                                     0)
                               || ' Minute '
                         END)
                     ELSE
                        NULL
                  END
                     TIME_REMAIN_LABEL,
                  CASE
                     WHEN ACT_BERTH_TS < TO_DATE('{$from}', 'YYYY-MM-DD') AND ACT_DEP_TS IS NULL
                     THEN
                        TO_DATE('{$from}', 'YYYY-MM-DD') + ( (DISC_REMAIN + LOAD_REMAIN) / BSH) / 24
                     ELSE
                        NULL
                  END
                     EST_END_DATE,
                  ROUND (
                       (  (  (  (CASE
                                    WHEN     ACT_BERTH_TS < TO_DATE('{$from}', 'YYYY-MM-DD')
                                         AND ACT_DEP_TS IS NULL
                                    THEN
                                         TO_DATE('{$from}', 'YYYY-MM-DD')
                                       +   (  (DISC_REMAIN + LOAD_REMAIN)
                                            / BSH)
                                         / 24
                                    ELSE
                                       NULL
                                 END)
                              - (TO_DATE (
                                       TO_CHAR (TO_DATE('{$from}', 'YYYY-MM-DD'), 'DD/MM/YYYY')
                                    || ' 00:00',
                                    'DD/MM/YYYY HH24:MI')))
                           * 24
                           * 60)
                        / 30)
                     * 10,
                     0)
                     Y_AKHIR_EST,
                  A.BERTH_FR_METRE_ORI,
                  A.BERTH_TO_METRE_ORI,
                  A.BERTH_FR_METRE,
                  A.BERTH_TO_METRE,
                  A.WIDTH_ORI,
                  A.WIDTH,
                  A.Y_AWAL,
                  A.Y_AKHIR,
                  A.OCEAN_INTERISLAND,
                  A.OCEAN_INTERISLAND_FAKE,
                  Y_AKHIR - Y_AWAL HEIGHT,
                  AGENT,
                  AGENT_NAME,
                  MOBILE AGENT_MOBILE,
                  IMAGE,
                  A.REAL_LOAD,
                  A.EST_DISCH,
                  A.REAL_DISCH,
                  A.BTOA_SIDE,
                  A.IS_SIMULATION,
                  A.BSH,
                  A.BCH,
                  A.NEXT_PORT,
                  A.DEST_PORT,
                  A.EST_LOAD,
                  A.EST_DISCHARGE,
                  A.INFO,
                  A.CRANE,
                  A.VES_TYPE,
                  A.VES_SERVICE,
                  A.IN_VOYAGE,
                  A.OUT_VOYAGE,
                  A.WINDOWS,
                  TENTATIF,
                  IS_UNREG
             FROM (  SELECT A.VES_ID,
                            A.VES_ID VES_ID_OLD,
                            A.VES_NAME,
                            A.VES_CODE,
                            CASE
                               WHEN A.EST_BERTH_TS <
                                       TO_DATE (
                                          TO_CHAR (TO_DATE('{$from}', 'YYYY-MM-DD'), 'DD/MM/YYYY'),
                                          'DD/MM/YYYY')
                               THEN
                                  TO_DATE (TO_CHAR (TO_DATE('{$from}', 'YYYY-MM-DD'), 'DD/MM/YYYY'),
                                           'DD/MM/YYYY')
                               ELSE
                                  A.EST_BERTH_TS
                            END
                               EST_BERTH_TS,
                            CASE
                               WHEN A.ACT_BERTH_TS > TO_DATE ('2010', 'YYYY')
                               THEN
                                  A.ACT_BERTH_TS
                            END
                               ACT_BERTH_TS,
                            A.EST_DEP_TS,
                            CASE
                               WHEN A.ACT_DEP_TS > TO_DATE ('2010', 'YYYY')
                               THEN
                                  A.ACT_DEP_TS
                            END
                               ACT_DEP_TS,
                            CASE
                               WHEN A.EST_PILOT_TS > TO_DATE ('2010', 'YYYY')
                               THEN
                                  A.EST_PILOT_TS
                            END
                               EST_PILOT_TS,
                            CASE
                               WHEN A.REQ_BERTH_TS > TO_DATE ('2010', 'YYYY')
                               THEN
                                  A.REQ_BERTH_TS
                            END
                               REQ_BERTH_TS,
                            EST_ANCHORAGE_TS,
                            EST_START_WORK_TS,
                            EST_END_WORK_TS,
                            DOCO_CUTOFF_TS,
                            RECV_CTR_CUTOFF_TS,
                            RECV_CARGO_CUTOFF_TS,
                            ACT_DEP_TS ACT_DEP_TS_ORI,
                            NVL (DISC_ACT, 0) DISC_ACT,
                            NVL (LOAD_ACT, 0) LOAD_ACT,
                            NVL (DISC_REMAIN, 0) DISC_REMAIN,
                            NVL (LOAD_REMAIN, 0) LOAD_REMAIN,
                            BERTH_FR_METRE BERTH_FR_METRE_ORI,
                            BERTH_TO_METRE BERTH_TO_METRE_ORI,
                            BERTH_FR_METRE * 2 BERTH_FR_METRE,
                            BERTH_TO_METRE * 2 BERTH_TO_METRE,
                            (BERTH_TO_METRE - BERTH_FR_METRE) WIDTH_ORI,
                            (BERTH_TO_METRE - BERTH_FR_METRE) * 2 WIDTH,
                            --ROUND((EST_BERTH_TS -
                            --(TO_DATE(TO_CHAR(TO_DATE('{$from}', 'YYYY-MM-DD'), 'DD/MM/YYYY')||' 00:00', 'DD/MM/YYYY HH24:MI')-7))*24*20, 0)
                            --Y_AWAL,
                            --ROUND((EST_DEP_TS -
                            --(TO_DATE(TO_CHAR(TO_DATE('{$from}', 'YYYY-MM-DD'), 'DD/MM/YYYY')||' 00:00', 'DD/MM/YYYY HH24:MI')-7))*24*20, 0)
                            --Y_AKHIR,
                            ROUND (
                                 (  (  (  (CASE
                                              WHEN A.EST_BERTH_TS <
                                                      TO_DATE (
                                                         TO_CHAR (TO_DATE('{$from}', 'YYYY-MM-DD'),
                                                                  'DD/MM/YYYY'),
                                                         'DD/MM/YYYY')
                                              THEN
                                                 TO_DATE (
                                                    TO_CHAR (TO_DATE('{$from}', 'YYYY-MM-DD'),
                                                             'DD/MM/YYYY'),
                                                    'DD/MM/YYYY')
                                              ELSE
                                                 A.EST_BERTH_TS
                                           END)
                                        - (TO_DATE (
                                                 TO_CHAR (TO_DATE('{$from}', 'YYYY-MM-DD'),
                                                          'DD/MM/YYYY')
                                              || ' 00:00',
                                              'DD/MM/YYYY HH24:MI')))
                                     * 24
                                     * 60)
                                  / 30)
                               * 10,
                               0)
                               Y_AWAL,
                            ROUND (
                                 (  (  (  EST_DEP_TS
                                        - (TO_DATE (
                                                 TO_CHAR (TO_DATE('{$from}', 'YYYY-MM-DD'),
                                                          'DD/MM/YYYY')
                                              || ' 00:00',
                                              'DD/MM/YYYY HH24:MI')))
                                     * 24
                                     * 60)
                                  / 30)
                               * 10,
                               0)
                               Y_AKHIR,
                            CASE
                               WHEN C.VES_TYPE = 'GC' THEN 'C'
                               ELSE A.OCEAN_INTERISLAND_FAKE
                            END
                               OCEAN_INTERISLAND_FAKE,
                            A.OCEAN_INTERISLAND,
                            A.BTOA_SIDE,
                            TRIM (B.AGENT) AGENT,
                            TRIM (B.FULL_NAME) AGENT_NAME,
                            TRIM (MOBILE) MOBILE,
                            B.IMAGE,
                            A.BKG_EXPORT REAL_LOAD,
                            A.EST_DISCHARGE EST_DISCH,
                            A.BKG_IMPORT REAL_DISCH,
                            A.IS_SIMULATION,
                            A.BSH,
                            A.BCH,
                            A.NEXT_PORT,
                            A.DEST_PORT,
                            A.EST_LOAD,
                            A.EST_DISCHARGE,
                            A.VES_SERVICE,
                            TRIM (A.IN_VOYAGE) IN_VOYAGE,
                            TRIM (A.OUT_VOYAGE) OUT_VOYAGE,
                            A.INFO,
                            A.CRANE,
                            C.VES_TYPE,
                            A.WINDOWS,
                            TENTATIF,
                            IS_UNREG
                       FROM CBSLAM.VESSEL_DETAILS_SIM A,
                            CBSLAM.CUSTOMER B,
                            CBSLAM.VESSELS C,
                            (  SELECT dd.ves_id, COUNT (1) DISC_REMAIN
                                 FROM cbslam.item_bayplan dd
                             GROUP BY DD.VES_ID) D,
                            (  SELECT gg.dep_car VES_ID, COUNT (1) LOAD_REMAIN
                                 FROM    cbslam.item gg
                                      LEFT JOIN
                                         cbslam.w_item_stop ggg
                                      ON (gg.item_key = ggg.item_key)
                                WHERE     ggg.item_key IS NULL
                                      AND gg.hist_flg = 'N'
                                      AND gg.item_class IN ('E', 'T')
                             GROUP BY gg.dep_car) E,
                            (  SELECT TRIM (ee.arr_car) ves_id,
                                      COUNT (1) DISC_ACT
                                 FROM cbslam.item ee
                                WHERE ee.hist_flg = 'N'
                             GROUP BY ee.arr_car) F,
                            (  SELECT TRIM (ff.dep_car) VES_ID,
                                      COUNT (ff.item_key) LOAD_ACT
                                 FROM cbslam.item ff
                                WHERE     ff.hist_flg = 'Y'
                                      AND ARR_TS > TO_DATE('{$from}', 'YYYY-MM-DD') - 7
                                      AND ff.item_class IN ('E', 'T')
                             GROUP BY ff.dep_car) G
                      WHERE     (   EST_BERTH_TS >=
                                       TO_DATE (
                                          TO_CHAR (TO_DATE('{$from}', 'YYYY-MM-DD'), 'DD/MM/YYYY'),
                                          'DD/MM/YYYY')
                                 OR EST_DEP_TS >
                                       TO_DATE (
                                          TO_CHAR (TO_DATE('{$from}', 'YYYY-MM-DD'), 'DD/MM/YYYY'),
                                          'DD/MM/YYYY'))
                            AND EST_BERTH_TS > TO_DATE('{$from}', 'YYYY-MM-DD') - 7
                            AND EST_BERTH_TS <=
                                     TO_DATE (TO_CHAR (TO_DATE('{$from}', 'YYYY-MM-DD'), 'DD/MM/YYYY'),
                                              'DD/MM/YYYY')
                                   + 7
                            AND TRIM (A.AGENT) = TRIM (B.AGENT(+))
                            AND A.VES_CODE = C.VES_CODE(+)
                            AND TRIM (A.VES_ID) = TRIM (D.VES_ID(+))
                            AND TRIM (A.VES_ID) = TRIM (E.VES_ID(+))
                            AND TRIM (A.VES_ID) = TRIM (F.VES_ID(+))
                            AND TRIM (A.VES_ID) = TRIM (G.VES_ID(+))
                   ORDER BY EST_BERTH_TS DESC) A) A
                   WHERE ocean_interisland_fake='{$ocean_interisland_fake}'
                   and EST_BERTH_TS BETWEEN TO_DATE('{$from}', 'YYYY-MM-DD') AND TO_DATE('{$to} 23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
    }
}
