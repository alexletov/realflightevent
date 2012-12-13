<table width="100%">
<tr>
<td>Event</td>
<td>Closed</td>
<td></td>
<td></td>
<td></td>
</tr>
{foreach from=$events item=event}
<tr>
<td>{$event->name}</td>
<td>{$event->closed}</td>
<td><a href="/admin/arrivals/{$event->id}">Arrivals</a></td>
<td><a href="/admin/departures/{$event->id}">Departures</a></td>
<td><a href="/admin/editevent/{$event->id}">Edit</a></td>
</tr>
{/foreach}
</table>