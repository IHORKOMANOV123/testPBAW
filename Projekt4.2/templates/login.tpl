{extends file="main.tpl"}

{block name=title}{$page_title|default:"Logowanie"}{/block}

{block name=header_content}
    <h1>{$page_header|default:"Logowanie do systemu"}</h1>
{/block}

{block name=content}
    <section>
        <form method="post" action="{$conf->action_url}doLogin"> {* Action should be doLogin *}
            <div class="row gtr-uniform">
                <div class="col-6 col-12-xsmall">
                    <label for="login">Login</label>
                    <input type="text" name="login" id="login" value="" /> {* No need to retain login value usually *}
                </div>
                <div class="col-6 col-12-xsmall">
                    <label for="pass">Hasło</label>
                    <input type="password" name="pass" id="pass" value="" />
                </div>
                <div class="col-12">
                    <ul class="actions">
                        <li><input type="submit" value="Zaloguj" class="primary" /></li>
                    </ul>
                </div>
            </div>
        </form>
    </section>
{/block}
