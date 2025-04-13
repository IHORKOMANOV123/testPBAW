<!DOCTYPE HTML>
<html>
<head>
    <title>Kalkulator Kredytowy</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
    <style>
        html {
            scroll-behavior: smooth;
        }
        section {
            padding: 4em 0;
        }
        #welcome {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: #f4f4f4;
            animation: fadeIn 1s ease-in-out;
        }
        #welcome-box {
            background: white;
            padding: 2em;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        #login {
            background-image: url('images/pic01.jpg');
            background-size: cover;
            background-position: center;
        }
        #login .inner {
            background: rgba(255, 255, 255, 0.9);
            padding: 2em;
            border-radius: 12px;
            max-width: 400px;
            margin: auto;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="is-preload">

    <!-- Welcome -->
    <section id="welcome">
        <div id="welcome-box">
            {if $is_logged_in}
                <h2>Teraz możesz obliczyć swoją ratę kredytu!</h2>
                <a href="#calculator" class="button primary">Oblicz</a>
            {else}
                <h2>Cześć! Jeśli chcesz skorzystać z kalkulatora, najpierw się zaloguj!</h2>
                <a href="#login" class="button primary">Login</a>
            {/if}
        </div>
    </section>

    <!-- Login -->
    {if !$is_logged_in}
    <section id="login" class="wrapper">
        <div class="inner">
            <h3>Logowanie</h3>
            {if count($msgs) > 0}
                <div style="color:red;">
                    {foreach from=$msgs item=msg}
                        <p>{$msg}</p>
                    {/foreach}
                </div>
            {/if}
            <form method="post" action="login.php">
                <input type="text" name="username" placeholder="{$username|default:'Login'}" required />
                <input type="password" name="password" placeholder="Hasło" required />
                <button type="submit" class="button">Zaloguj się</button>
            </form>
        </div>
    </section>
    {/if}

    <!-- Calculator -->
    {if $is_logged_in}
    <section id="calculator" class="wrapper">
        <div class="inner" style="max-width:500px;margin:auto;">
            <h3>Kalkulator</h3>
            <form method="post" action="calc.php">
                <input type="number" name="kwota" placeholder="Kwota kredytu" value="{$form->kwota|default:''}" required />
                <input type="number" name="lat" placeholder="Liczba lat" value="{$form->lat|default:''}" required />
                <input type="number" step="0.1" name="procent" placeholder="Oprocentowanie" value="{$form->procent|default:''}" required />
                <button type="submit" class="button primary">Oblicz ratę</button>
            </form>

            {if $result->monthlyPayment}
                <div class="box" style="margin-top: 1em; background-color: #dff0d8;">
                    <strong>Rata miesięczna:</strong> {$result->monthlyPayment} PLN
                </div>
            {/if}

            {if count($messages) > 0}
                <div class="box" style="margin-top: 1em; background-color: #f8d7da;">
                    {foreach from=$messages item=msg}
                        <p>{$msg}</p>
                    {/foreach}
                </div>
            {/if}

            <a href="logout.php" class="button small">Wyloguj się</a>
        </div>
    </section>
    {/if}

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.scrolly.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>

</body>
</html>
