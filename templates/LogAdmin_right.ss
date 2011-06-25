<div class="Logs">
    <% if Log %>
        <% control Log %>
            <div class="Log">
                    <h2>$Log.File ($Path)</h2>
                    $Data.Value
            </div>
        <% end_control %>
    <% else %>
        <p>No logs available</p>
    <% end_if %>
</div>