<link rel="icon" type="image/png" href="favicon/favicon-96x96.png" sizes="96x96"/>
<link rel="icon" type="image/svg+xml" href="favicon/favicon.svg"/>
<link rel="shortcut icon" href="favicon/favicon.ico"/>
<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png"/>
<meta name="apple-mobile-web-app-title" content="DODOWORKOUT"/>
<link rel="manifest" href="favicon/site.webmanifest"/>

<meta http-equiv="X-UA-Compatible" content="ie=edge">

@if(app()->currentLocale() === "sk")
    <meta name="description" content="Dodoworkout - Web stránka Dominika Klimeka, profesionálneho atléta kalisteniky a street workoutu, majstra sveta (2022) a certifikovaného trénera WSWCF Academy. Pomôžem vám dosiahnuť vaše športové ciele a vybudovať disciplínu na ceste k úspechu.">
    <meta name="keywords" content="kalistenika, street workout, osobný tréner, Dominik Klimek, Dodoworkout, workout, cvičenie s vlastnou váhou, vlastná váha, inšpirácia mladých">
@else
    <meta name="keywords" content="calisthenics, street workout, personal trainer, Dominik Klimek, Dodoworkout, workout, bodyweight exercises, bodyweight training, youth inspiration">
    <meta name="description" content="Dodoworkout - Website of Dominik Klimek, a professional calisthenics and street workout athlete, world champion (2022), and certified trainer of the WSWCF Academy. I help people achieve their calisthenics goals and build discipline needed for success.">
@endif

<!-- Open Graph Meta Tags for Social Media -->
@if(app()->currentLocale() === "sk")
    <meta property="og:title" content="Dodoworkout - Profesionálny tréner kalisteniky">
    <meta property="og:description" content="Web stránka Dominika Klimeka, profesionálneho atléta kalisteniky a street workoutu, majstra sveta (2022) a certifikovaného trénera WSWCF Academy.">
@else
    <meta property="og:title" content="Dodoworkout - Professional Calisthenics Coach">
    <meta property="og:description" content="Website of Dominik Klimek, a professional calisthenics and street workout athlete, world champion (2022), and certified coach of the WSWCF Academy.">
@endif

<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
<meta property="og:site_name" content="DODOWORKOUT">

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
@if(app()->currentLocale() === "sk")
    <meta name="twitter:title" content="Dodoworkout - Profesionálny tréner kalisteniky">
    <meta name="twitter:description" content="Web stránka Dominika Klimeka, profesionálneho trénera kalisteniky a street workoutu, majstra sveta (2022).">
@else
    <meta name="twitter:title" content="Dodoworkout - Professional Calisthenics Coach">
    <meta name="twitter:description" content="Website of Dominik Klimek, a professional calisthenics and street workout coach, world champion (2022).">
@endif
<meta name="twitter:image" content="{{ asset('images/twitter-image.jpg') }}">

<!-- Additional SEO Meta Tags -->
<meta name="robots" content="index, follow">
<meta name="googlebot" content="index, follow">
<link rel="canonical" href="{{ url()->current() }}">
