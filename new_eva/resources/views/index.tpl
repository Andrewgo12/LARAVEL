{extends file='layouts/main.tpl'}

{block name=title}
    This is a new feature
{/block}
{block name=body}
    <main class="flex-shrink-0">
        <div class="container">
            <h1 class="mt-5">Sticky footer with fixed navbar</h1>
            <p class="lead">Pin a footer to the bottom of the viewport in desktop browsers with this custom HTML and
                CSS. A fixed navbar has been added with <code class="small">padding-top: 60px;</code> on the <code
                    class="small">main &gt; .container</code>.</p>
            <p>Back to <a href="/docs/5.1/examples/sticky-footer/">the default sticky footer</a> minus the navbar.</p>
        </div>
    </main>
{/block}