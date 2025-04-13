{extends file="main.tpl"}

{block name=title}{$page_title|default:"Kalkulator Zwykły"}{/block}

{block name=header_content}
    <h1>{$page_header|default:"Kalkulator Zwykły"}</h1>
    <p>{$page_description|default:"Proste operacje arytmetyczne"}</p>
{/block}

{block name=content}
    <section>
        <form method="post" action="{$conf->action_url}calcCompute">
            <div class="row gtr-uniform">
                <div class="col-6 col-12-xsmall">
                    <label for="x">Liczba 1</label>
                    <input type="text" name="x" id="x" value="{$form->x|default:""}" />
                </div>
                <div class="col-6 col-12-xsmall">
                     <label for="op">Operacja</label>
                     <select id="op" name="op">
                        {* You might want to select the previously chosen operation *}
                        <option value="plus" {if isset($form->op) && $form->op == 'plus'}selected{/if}>+</option>
                        <option value="minus" {if isset($form->op) && $form->op == 'minus'}selected{/if}>-</option>
                        <option value="times" {if isset($form->op) && $form->op == 'times'}selected{/if}>*</option>
                        <option value="div" {if isset($form->op) && $form->op == 'div'}selected{/if}>/</option>
                     </select>
                </div>
                <div class="col-6 col-12-xsmall">
                    <label for="y">Liczba 2</label>
                    <input type="text" name="y" id="y" value="{$form->y|default:""}" />
                </div>
                <div class="col-12">
                    <ul class="actions">
                        <li><input type="submit" value="Oblicz" class="primary" /></li>
                    </ul>
                </div>
            </div>
        </form>
    </section>

    {* Display results *}
    {if isset($result->result)}
        <div class="box result">
            <h4>Wynik:</h4>
            <p>{$result->result}</p>
        </div>
    {/if}
{/block}
