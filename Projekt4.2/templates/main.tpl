<!DOCTYPE HTML>
{* Base template for the application *}
<html>
<head>
	<title>{block name=title}Default Title{/block}</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    {block name=styles}
        {* --- ПРОВЕРЬТЕ ЭТИ ПУТИ --- *}
	    <link rel="stylesheet" href="{$conf->app_url}/assets/css/main.css" />
	    <noscript><link rel="stylesheet" href="{$conf->app_url}/assets/css/noscript.css" /></noscript>
        {* Добавьте сюда ссылки на другие CSS файлы, если они есть *}
        {* <link rel="stylesheet" href="{$conf->app_url}/assets/css/fontawesome-all.min.css" /> *}
    {/block}
</head>
<body class="is-preload">
	<div id="wrapper">

		<!-- Header -->
		<header id="header">
            {block name=header_content}
			    <h1>Default Header</h1>
			    <p>Default description</p>
            {/block}
            {block name=navigation}
                <nav>
                    <ul>
                       {if !isset($smarty.session.user_role)}
                           <li><a href="{$conf->action_url}login">Zaloguj</a></li>
                       {else}
                           <li>Zalogowany jako: {$smarty.session.user_login} (Rola: {$smarty.session.user_role})</li>
                           {if isset($smarty.session.user_role) && in_array($smarty.session.user_role, ['user', 'admin'])}
                               <li><a href="{$conf->action_url}calcShow">Kalk. Zwykły</a></li>
                               <li><a href="{$conf->action_url}creditShow">Kalk. Kredytowy</a></li>
                           {/if}
                           <li><a href="{$conf->action_url}logout">Wyloguj</a></li>
                       {/if}
                    </ul>
                </nav>
            {/block}
		</header>

		<!-- Main Content Area -->
		<div id="main">
            {block name=messages}
                {* Display messages *}
                {if isset($messages) && $messages->isError()} <div class="box error"><h4>Wystąpiły błędy:</h4><ul> {foreach $messages->getErrors() as $msg} <li>{$msg}</li> {/foreach} </ul></div> {/if}
                {if isset($messages) && $messages->isInfo()} <div class="box info"><h4>Informacje:</h4><ul> {foreach $messages->getInfos() as $msg} <li>{$msg}</li> {/foreach} </ul></div> {/if}
                {if isset($messages) && $messages->isWarning()} <div class="box warning"><h4>Ostrzeżenia:</h4><ul> {foreach $messages->getWarnings() as $msg} <li>{$msg}</li> {/foreach} </ul></div> {/if}
            {/block}

            {block name=content}
			    <p>Default content goes here.</p>
            {/block}
		</div>

		<!-- Footer -->
		<footer id="footer">
            {block name=footer}
			    <p class="copyright">&copy; Your Name/Company. Design: <a href="https://html5up.net">HTML5 UP</a>.</p>
            {/block}
 		</footer>

	</div>

	<!-- Scripts -->
    {block name=scripts}
        {* --- ПРОВЕРЬТЕ ЭТИ ПУТИ --- *}
	    <script src="{$conf->app_url}/assets/js/jquery.min.js"></script>
	    <script src="{$conf->app_url}/assets/js/jquery.scrollex.min.js"></script>
	    <script src="{$conf->app_url}/assets/js/jquery.scrolly.min.js"></script>
	    <script src="{$conf->app_url}/assets/js/browser.min.js"></script>
	    <script src="{$conf->app_url}/assets/js/breakpoints.min.js"></script>
	    <script src="{$conf->app_url}/assets/js/util.js"></script>
	    <script src="{$conf->app_url}/assets/js/main.js"></script>
    {/block}

</body>
</html>
