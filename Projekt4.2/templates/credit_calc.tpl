{extends file="main.tpl"}

{block name=title}{$page_title|default:"Kalkulator Kredytowy"}{/block}

{block name=header_content}
    <h1>{$page_header|default:"Kalkulator Kredytowy"}</h1>
    <p>{$page_description|default:"Obliczanie miesięcznej raty kredytu"}</p>
{/block}

{block name=content}
    <section>
        <form method="post" action="{$conf->action_url}creditCompute">
            <div class="row gtr-uniform">
                <div class="col-6 col-12-xsmall">
                    <label for="amount">Kwota kredytu (PLN)</label>
                    <input type="text" name="amount" id="amount" value="{$form->amount|default:""}" />
                </div>
                <div class="col-6 col-12-xsmall">
                    <label for="years">Okres spłaty (lata)</label>
                    <input type="text" name="years" id="years" value="{$form->years|default:""}" />
                </div>
                <div class="col-6 col-12-xsmall">
                    <label for="interestRate">Oprocentowanie roczne (%)</label>
                    <input type="text" name="interestRate" id="interestRate" value="{$form->interestRate|default:""}" />
                </div>
                <div class="col-12">
                    <ul class="actions">
                        <li><input type="submit" value="Oblicz ratę" class="primary" /></li>
                    </ul>
                </div>
            </div>
        </form>
    </section>

    {* Results are displayed after the form within the main content block *}
    {if isset($result->monthlyPayment)}
        <div class="box result">
            <h4>Wynik:</h4>
            <p>Miesięczna rata: {$result->monthlyPayment|string_format:"%.2f"} PLN</p>
            <p>Całkowita kwota do spłaty: {$result->totalAmount|string_format:"%.2f"} PLN</p>
        </div>
    {/if}
{/block}
