<div class="Logs">
    <% if Log %>
        <% control Log %>
            <div class="Log">
                <h2>$Filename ($Path)</h2>
                $Data
            </div>
        <% end_control %>
    <% else %>
        <p>No logs available</p>
    <% end_if %>
</div>