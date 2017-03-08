<h1>Channels</h1>




<div class="row">
    {foreach $channels as $channel}
    <div class="col-md-4">
        <div class="well text-center">
            <a href="/channels/{$channel.channeltag}">
            {$channel.channelname}<br />
            <img src="{$channel.channellogo}" /></a>

            <br />&nbsp;
        </div>
    </div>

    {/foreach}
</div>


{$channels|var_dump}