<h1><img src="{$channel.channellogo}" /> {$channel.channelname|escape} ({$channel.channelnumber})</h1>

<p>{$channel.description}</p>

{if $channel.channelurl}
    <p><strong>Website:</strong> <a href="{$channel.channelurl}">{$channel.channelurl}</a></p>
{/if}


<h3>Schedule</h3>

<table class="table table-striped">
    {foreach $schedule as $item}
        <tr>
            <td class="nowrap">{$item.starttime|date_format:"%I:%M %p"}</td>
            <td>
                <strong>{$item.title}</strong>

                <p>{$item.description|escape}</p>

            </td>
        </tr>
    {/foreach}
</table>
