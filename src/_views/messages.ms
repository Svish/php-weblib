{{#list}}
<div class="message {{type}}">{{text | fl}}
{{#_s}}{{text | rf}}{{/_s}}</div>
{{/list}}

{{! TODO: Load via JS, and don't show exception details}}

{{!#svg}}{{!type}}{{!/svg}}
