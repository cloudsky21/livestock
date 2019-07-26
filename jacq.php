<?php
session_start();
include "connection/conn.php";
include 'myload.php';
date_default_timezone_set('Asia/Manila');

use Classes\programtables;
#use Classes\group;

$obj = new programtables;

$table = $obj->agriagra();
$html = "";
$data = array(
    2877,
    2878,
    2879,
    2880,
    2881,
    2882,
    2883,
    2884,
    2887,
    2888,
    2889,
    2890,
    2891,
    2892,
    2893,
    2894,
    2876,
    2885,
    2886,
    2942,
    2943,
    2944,
    2945,
    2946,
    2947,
    2948,
    1543,
    2870,
    2812,
    2813,
    2814,
    2815,
    2816,
    2817,
    2818,
    2819,
    2820,
    2821,
    2822,
    2823,
    2824,
    2825,
    2826,
    2827,
    2828,
    2829,
    2830,
    2831,
    2832,
    2833,
    2834,
    2835,
    2836,
    2837,
    2838,
    2839,
    2840,
    2841,
    2842,
    2843,
    2844,
    2845,
    2846,
    2847,
    2848,
    2849,
    2850,
    2851,
    2852,
    2853,
    2854,
    2855,
    2856,
    2857,
    2858,
    2859,
    2860,
    2861,
    2862,
    2863,
    2864,
    2865,
    2866,
    2867,
    2868,
    2869,
    2871,
    2872,
    2873,
    2874,
    2875,
    3053,
    3054,
    3055,
    3056,
    3057,
    3058,
    3059,
    3060,
    3073,
    3063,
    3064,
    3065,
    3066,
    3067,
    3069,
    3070,
    3071,
    3072,
    3061,
    3062,
    3068,
    3028,
    3029,
    3030,
    3031,
    3032,
    3033,
    3034,
    3035,
    3036,
    3037,
    3038,
    3039,
    3040,
    3041,
    3042,
    3051,
    3052,
    3044,
    3045,
    3046,
    3047,
    3048,
    3049,
    3050,
    3043,
    2895,
    2896,
    2897,
    2898,
    2902,
    2903,
    2899,
    2900,
    2901,
    2916,
    2917,
    2904,
    2905,
    2906,
    2907,
    2908,
    2909,
    2910,
    2911,
    2912,
    2913,
    2914,
    2915,
    2918,
    2919,
    2923,
    2924,
    2925,
    2926,
    2927,
    2928,
    2920,
    2921,
    2922,
    2929,
    2930,
    2931,
    2932,
    2938,
    2939,
    2940,
    2941,
    2936,
    2937,
    2933,
    2934,
    2935,
    2959,
    2960,
    2961,
    2967,
    2968,
    2969,
    2979,
    2980,
    2981,
    2982,
    2957,
    2958,
    2962,
    2963,
    2964,
    2965,
    2966,
    2970,
    2971,
    2972,
    2973,
    2974,
    2975,
    2976,
    2977,
    2978,
    2951,
    2949,
    2951,
    2952,
    2953,
    2954,
    2955,
    2956,
    2983,
    2984,
    2985,
    2986,
    2987,
    2988,
    2989,
    2990,
    2991,
    2992,
    2993,
    2994,
    2995,
    2996,
    2997,
    2998,
    3010,
    3011,
    3012,
    3013,
    3014,
    3015,
    3016,
    3017,
    3018,
    3019,
    3020,
    3021,
    3022,
    3023,
    3024,
    3025,
    3026,
    3027,
    2999,
    3000,
    3001,
    3002,
    3003,
    3004,
    3005,
    3006,
    3007,
    3008,
    3009,
);
$totalheads = 0;
$totalAC = 0;
$totalPremium = 0;
$i = 1;

foreach ($data as $key) {
    # code...
    $result = $db->prepare("SELECT amount_cover, premium, heads FROM $table WHERE idsnumber = ?");
    $result->execute([$key]);

    foreach ($result as $values) {
        $html .= '<tr>';
        $html .= '<td>' . $i++ . '</td>';
        //$html .= '<td class="text-center"><input type="checkbox" style="width:20px; height:20px;"></td>';

        $html .= '<td>' . number_format($values['amount_cover'], 2) . '</td>';
        $html .= '<td>' . number_format($values['premium'], 2) . '</td>';
        $html .= '<td>' . number_format($values['heads']) . '</td>';
        $html .= '</tr>';

        $totalAC += $values['amount_cover'];
        $totalPremium += $values['premium'];
        $totalheads += $values['heads'];
    }

}
$html .= '<tr>';

$html .= '<td></td>';
//$html .= '<td class="text-center"><strong>Grand Total</strong></td>';
$html .= '<td><strong>' . number_format($totalAC, 2) . '</strong></td>';
$html .= '<td><strong>' . number_format($totalPremium, 2) . '</strong></td>';
$html .= '<td><strong>' . number_format($totalheads) . '</strong></td>';
$html .= '</tr>';
?>
<!DOCTYPE html>

<head>
    <title>Table Data Printing</title>
    <link rel="stylesheet" href="resources/bootswatch/solar/bootstrap.css">
    <link rel="stylesheet" href="resources/css/font-awesome/css/font-awesome.css">
</head>

<body>
    <div class="container">
        <h3 class="text-center">Livestock - RSBSA</h3>
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Amount of Cover</th>
                    <th>Premium</th>
                    <th>No. of Heads</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $html ?>
            </tbody>
        </table>

    </div>
</body>

</html>