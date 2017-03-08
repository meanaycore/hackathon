<div class="jumbotron">
    <h1>TV Guide Mashup</h1>
    <ul>
        <li>Vanity Project - Your favourite TV shows in your calendar + Recommend Shows</li>
        <li> Compare: http://guide.dstv.com - Make it easier to find shows<ul>
                <li>Random Benefits :-</li>
                <li>Less time finding shows</li>
                <li>Know when to avoid standby</li>
            </ul></li>
        <li>Technology: <small style="font-size: 60%;">PHP</small>, Redis, Resque</li>
        <li>Sources (Find the best info, relevant images): <ul>
        <li>DSTV Website JSON</li>
        <li>Open Movie Database API</li>
        <li>thetvdb.com API</li>
            </ul></li>

        <li>With more time: Recommendation, chatbot, personalisation, next-episode.net, trakt</li>
    </ul>



</div>

<h1>Top Movies Showing Today</h1>

{foreach $movies as $item}
    <div class="media">
        <div class="media-left media-top">
            <a href="/series/{$item.shorturl}">
                <img class="media-object" src="{$item.showimage}?a" class="img-responsive" style=" max-width: 100px"/>
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">
                <a href="/movie/{$item.shorturl}">{$item.title}</a>
            </h4>
            <p>{$item.description|truncate:400}</p>
        </div>
    </div>
{/foreach}


<h1>Top Series Showing Today</h1>

{foreach $series as $item}
    <div class="media">
        <div class="media-left media-top">
            <a href="/series/{$item.shorturl}">
                <img class="media-object" src="{$item.showimage}?a" class="img-responsive" style=" max-width: 100px"/>
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">
                <a href="/series/{$item.shorturl}">{$item.title}</a>
            </h4>
            <p>{$item.description|truncate:400}</p>
        </div>
    </div>
{/foreach}