<?php
/**
 * The header for our theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package 3cb24
 */

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php acf_form_head(); ?>
	<div id="wrap" class="wrap">
		<header id="header">
			<div class="container">
				<div id="headerMenuMobile"><button class="menu-trigger navclosed"><span>Menu</span></button></div>
				<div id="headerContactMobile"><a href="<?php echo esc_url( home_url() ); ?>/contact-us/" class="">Contact</a></div>
				<div id="headerLogo">
					<a href="<?php echo esc_url( home_url() ); ?>" title="<?php bloginfo( 'name' ); ?>"><svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500.000000 530.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,530.000000) scale(0.100000,-0.100000)" stroke="none"><path d="M2484 5029 c-71 -27 -137 -88 -171 -157 -25 -51 -28 -67 -27 -157 0 -89 4 -109 33 -180 30 -73 34 -92 38 -213 5 -127 7 -134 29 -149 22 -14 26 -14 49 1 25 16 25 18 25 153 0 75 -5 176 -11 224 -13 100 -1 198 29 238 36 49 66 63 130 63 77 0 115 -22 144 -81 25 -51 26 -84 13 -392 l-8 -187 26 -17 c20 -13 30 -14 47 -5 32 17 40 51 40 170 0 88 4 119 21 162 54 132 63 250 27 345 -29 77 -104 152 -181 181 -75 29 -182 29 -253 1z"/><path d="M2183 4470 c-42 -17 -55 -62 -51 -180 3 -99 5 -111 27 -134 33 -35 83 -35 116 -1 24 23 25 30 25 147 -1 128 -5 144 -47 166 -25 14 -40 14 -70 2z"/><path d="M2952 4455 l-32 -27 0 -124 c0 -119 1 -126 25 -149 30 -31 82 -33 113 -5 28 26 35 68 30 184 -3 106 -16 130 -74 142 -24 4 -37 0 -62 -21z"/><path d="M2550 4427 c-38 -29 -50 -61 -50 -128 0 -61 3 -70 30 -97 49 -49 111 -50 159 -1 51 51 51 158 -1 210 -24 24 -38 29 -76 29 -26 0 -54 -6 -62 -13z"/><path d="M2467 4103 c-4 -3 -7 -67 -7 -141 l0 -135 38 9 c71 16 173 10 225 -13 l47 -22 0 155 0 154 -148 0 c-82 0 -152 -3 -155 -7z"/><path d="M1295 3986 c-27 -7 -105 -40 -171 -73 -67 -33 -163 -75 -213 -93 -50 -18 -91 -37 -91 -41 0 -16 75 -47 140 -59 88 -16 128 -8 242 51 243 123 350 108 645 -90 65 -44 131 -91 147 -104 l29 -24 -35 -21 c-43 -26 -114 -102 -130 -138 -7 -15 -33 -36 -62 -51 -28 -14 -68 -39 -88 -55 -43 -34 -88 -118 -88 -165 l0 -34 58 59 c63 65 113 95 154 94 14 0 63 -12 108 -26 48 -15 105 -26 138 -26 40 0 70 -7 97 -21 99 -53 125 -63 202 -78 l83 -16 0 -137 0 -138 155 0 155 0 0 174 0 174 47 -18 c55 -21 61 -31 38 -66 -16 -24 -15 -27 1 -45 20 -22 67 -25 83 -5 10 11 8 17 -6 25 -17 10 -17 12 6 29 l23 19 -35 65 -35 66 33 -8 c76 -17 143 -80 184 -174 19 -43 23 -47 38 -35 22 19 49 85 57 140 6 43 5 46 -31 76 -29 23 -42 43 -52 82 -7 28 -19 55 -28 59 -8 5 -23 21 -33 36 l-18 28 37 33 c71 63 295 227 375 273 159 94 199 107 312 107 l100 0 128 -62 c119 -59 132 -63 197 -63 86 0 147 14 183 43 l28 22 -114 44 c-62 24 -153 65 -203 91 -127 68 -186 83 -319 82 -206 -2 -325 -48 -569 -220 -86 -61 -182 -123 -212 -137 l-55 -27 -67 57 c-38 32 -99 73 -138 92 -116 55 -180 46 -390 -59 l-110 -55 -58 36 c-31 20 -112 75 -180 123 -213 151 -310 188 -512 194 -88 2 -146 -1 -180 -10z m821 -562 c19 -9 39 -25 45 -35 9 -18 4 -19 -122 -19 -121 0 -130 1 -118 17 20 24 89 53 127 53 19 0 49 -7 68 -16z"/><path d="M1390 3806 c-30 -6 -103 -37 -161 -67 -99 -51 -105 -56 -96 -77 5 -12 30 -31 54 -43 83 -40 186 -10 308 90 38 31 79 61 90 65 18 8 18 9 -10 21 -48 20 -125 25 -185 11z"/><path d="M3694 3800 c-68 -16 -69 -18 -28 -47 22 -14 59 -44 84 -65 60 -53 105 -75 178 -87 77 -12 122 0 157 41 l26 30 -63 34 c-181 98 -257 118 -354 94z"/><path d="M1591 3729 c-13 -5 -57 -36 -98 -69 -46 -37 -92 -65 -119 -72 -48 -13 -52 -19 -28 -42 29 -30 59 -40 119 -39 79 1 119 20 185 88 30 31 67 63 83 71 37 20 34 30 -13 54 -42 21 -90 25 -129 9z"/><path d="M3512 3720 c-49 -22 -61 -39 -36 -53 10 -6 48 -39 84 -73 78 -75 119 -94 198 -94 45 0 67 5 92 23 47 31 46 41 -2 54 -26 7 -76 38 -126 77 -46 37 -96 69 -110 72 -15 3 -34 7 -44 8 -9 2 -34 -4 -56 -14z"/><path d="M750 3690 c-14 -4 -65 -26 -115 -48 -49 -22 -108 -44 -129 -48 l-40 -7 30 -24 c88 -70 239 -88 354 -40 78 33 200 104 200 117 0 6 -17 10 -38 10 -21 0 -72 11 -112 25 -76 26 -107 29 -150 15z"/><path d="M4305 3665 c-38 -13 -88 -24 -110 -25 l-40 -1 30 -24 c44 -37 182 -103 247 -119 77 -20 163 -7 247 36 36 18 66 38 68 44 2 7 -14 13 -40 16 -23 3 -83 24 -132 47 -115 54 -172 60 -270 26z"/><path d="M1735 3612 c-17 -11 -42 -35 -57 -54 -15 -20 -48 -46 -73 -58 l-46 -22 33 -24 c56 -42 97 -49 164 -29 49 14 68 27 121 83 35 36 62 66 61 68 -2 1 -26 14 -54 28 -61 31 -108 33 -149 8z"/><path d="M3395 3620 c-28 -6 -115 -47 -115 -54 0 -13 126 -130 154 -141 57 -24 135 -19 179 10 20 14 37 30 37 34 0 5 -14 14 -31 21 -16 7 -56 39 -88 70 -61 59 -86 70 -136 60z"/><path d="M1040 3553 c-14 -2 -69 -25 -123 -50 -53 -25 -115 -47 -137 -50 -22 -3 -40 -11 -40 -17 1 -16 32 -52 58 -65 50 -26 213 -7 292 34 34 18 139 101 157 124 9 12 9 18 0 23 -12 8 -163 8 -207 1z"/><path d="M4018 3552 c-32 -2 -58 -7 -58 -11 0 -16 106 -106 159 -135 134 -72 296 -75 345 -5 23 33 21 36 -25 42 -23 3 -84 26 -136 51 -109 53 -168 65 -285 58z"/><path d="M3205 3508 c-11 -6 -40 -27 -63 -47 -40 -32 -42 -36 -26 -48 12 -9 48 -13 108 -12 50 0 99 -3 109 -7 18 -6 18 -4 -2 33 -21 42 -74 93 -94 93 -7 0 -21 -6 -32 -12z"/><path d="M1235 3453 c-16 -10 -59 -37 -94 -61 -36 -23 -82 -45 -103 -48 -43 -7 -48 -22 -17 -50 18 -16 37 -19 123 -19 100 0 104 1 188 43 84 41 190 123 176 137 -3 4 -60 9 -125 11 -101 4 -122 2 -148 -13z"/><path d="M3738 3453 c-16 -2 -28 -8 -28 -13 0 -18 99 -92 179 -132 81 -42 86 -43 180 -43 76 0 103 4 124 18 40 26 33 40 -29 60 -30 9 -87 40 -126 67 l-71 50 -101 -1 c-56 -1 -113 -4 -128 -6z"/><path d="M1520 3377 c-14 -7 -49 -30 -78 -50 -30 -20 -71 -42 -93 -48 -21 -7 -39 -16 -39 -20 0 -22 64 -58 114 -64 84 -11 152 13 199 70 21 25 57 58 79 73 l41 27 -34 7 c-80 17 -164 19 -189 5z"/><path d="M3521 3370 c-35 -5 -66 -12 -69 -15 -12 -12 97 -98 167 -132 65 -32 85 -36 143 -35 72 1 121 19 138 52 9 17 6 20 -27 29 -21 6 -69 32 -107 58 -59 41 -76 47 -125 49 -31 1 -85 -1 -120 -6z"/><path d="M3170 3342 c0 -32 66 -123 110 -153 56 -38 140 -63 183 -54 17 4 52 19 77 33 44 25 44 25 20 35 -75 30 -114 53 -157 91 -67 60 -82 66 -162 66 -62 0 -71 -2 -71 -18z"/><path d="M380 2860 l0 -120 -70 0 -70 0 0 -125 0 -125 1110 0 1110 0 0 -428 0 -427 80 -80 80 -80 75 75 75 74 0 433 0 433 65 0 65 0 0 -33 c0 -89 83 -298 164 -412 54 -75 85 -90 188 -90 67 0 80 3 102 24 14 14 26 31 26 39 0 8 -22 45 -50 81 -86 118 -139 251 -140 354 l0 37 56 0 c53 0 59 -3 107 -46 63 -56 109 -80 197 -103 63 -16 72 -21 111 -72 81 -102 229 -233 354 -314 198 -129 410 -208 628 -233 l67 -8 0 278 c0 224 -3 278 -13 278 -26 0 -403 51 -532 71 -170 28 -221 47 -278 108 -54 58 -67 98 -67 209 l0 82 -80 0 -80 0 0 60 0 60 -145 0 -145 0 0 -59 0 -58 -1397 1 -1398 1 -3 118 -3 117 -94 0 -95 0 0 -120z"/><path d="M1565 1820 c-61 -13 -98 -49 -143 -136 -42 -83 -52 -150 -52 -362 l0 -201 58 -3 57 -3 3 -342 2 -343 110 0 110 0 0 345 0 345 60 0 60 0 0 188 c0 209 -11 276 -60 370 -59 114 -124 159 -205 142z"/><path d="M3590 1818 c-42 -11 -104 -69 -132 -123 -55 -106 -61 -138 -66 -362 l-4 -213 61 0 61 0 0 -345 0 -346 113 3 112 3 3 343 2 342 56 0 56 0 -4 228 c-3 205 -6 232 -26 282 -60 151 -136 212 -232 188z"/><path d="M2381 1550 c-89 -123 -79 -271 25 -378 l54 -56 0 -173 0 -173 -135 0 -135 0 0 -140 0 -140 420 0 420 0 0 140 0 140 -130 0 -130 0 0 171 0 171 54 53 c63 62 89 127 88 217 -1 62 -31 140 -72 187 l-21 25 -102 -102 -102 -102 -102 101 -101 102 -31 -43z"/><path d="M1770 630 l0 -140 75 0 75 0 0 140 0 140 -75 0 -75 0 0 -140z"/><path d="M1980 630 l0 -140 75 0 75 0 0 140 0 140 -75 0 -75 0 0 -140z"/><path d="M3097 763 c-4 -3 -7 -66 -7 -140 l0 -133 75 0 75 0 0 140 0 140 -68 0 c-38 0 -72 -3 -75 -7z"/><path d="M3300 630 l0 -140 75 0 75 0 0 140 0 140 -75 0 -75 0 0 -140z"/><path d="M1340 290 l0 -90 260 0 260 0 0 90 0 90 -260 0 -260 0 0 -90z"/><path d="M3360 285 l0 -85 260 0 260 0 0 85 0 85 -260 0 -260 0 0 -85z"/></g></svg></a>
				</div>
				<nav id="nav2" class="clearfix">
					<div class="navInner">
					<?php
					wp_nav_menu(
						array(
							'container'      => false,
							'theme_location' => 'main-menu',
						)
					);
					?>
					</div>
				</nav>
				<div id="headerLogin">
					<?php if ( ! is_user_logged_in() ) { ?>
					<?php } else { ?>
						<strong>Welcome: </strong>Logged in as <span class="username"><?php echo esc_html( wp_get_current_user()->user_login ); ?></span> &nbsp; <a href="/edit-user-profile/">Edit profile</a> &nbsp;
						<a href="/wp-login.php?action=logout">Log out</a>
					<?php } ?>
				</div>
			</div>
		</header>
		<div class="contentWrap">	