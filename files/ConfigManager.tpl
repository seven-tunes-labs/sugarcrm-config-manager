<!-- BEGIN: main -->
<form id="configForm" action="index.php?module=Administration&action=ConfigManager" method="POST" autocomplete="false">
    {csrf_token}
    <input style="display:none" type="text" name="fakeusernameremembered"/>
    <input style="display:none" type="password" name="fakepasswordremembered"/>

    <input type="hidden" name="type" value="searchConfig" id="searchType"/>
    <input type="hidden" name="sugar_body_only" value="true" id="sugar_body_only"/>

    <div class="moduleTitle">
        <h2>Config Manager</h2>
        <div class="clear"></div>
        <i>View/Update Runtime Configuration</i>
    </div>
    <div class="well">
        <div class="well" style="background: white;">
            <p></p>
            <table cellpadding="0" cellspacing="0" width="100%" class="h3Row">
                <tbody>
                <tr>
                    <td width="20%" valign="bottom"><h2>Search Config</h2></td>
                </tr>
                <tr>
                    <td style="padding-top: 3px; padding-bottom: 5px; font-size: 12px;">
                        <i>Search Sugar Config. Use dots for array separators. Eg: dbconfig.db_host_name</i>
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="other view">
                <tbody>
                <tr>
                    <td scope="row" width="10%">
                        Search Key:
                    </td>
                    <td>
                        <input type="text" name="key" autocomplete="false"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="Search Config" id="search-config" onclick="this.form.type.value = 'searchConfig';">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" id="searchResults" style="display: none;">
                        <pre style="margin-top: 0; background-color: lightyellow"></pre>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
        <div class="well" style="background: white;">

            <table cellpadding="0" cellspacing="0" width="100%" class="h3Row">
                <tbody>
                <tr>
                    <td width="20%" valign="bottom"><h2>Update Config</h2></td>
                </tr>
                <tr>
                    <td style="padding-top: 3px; padding-bottom: 5px; font-size: 12px;">
                        <i>Creates an entry in config_override.php - Can logout users! Please be careful when you do this change</i>
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="other view">
                <tbody>
                <tr>
                    <td width="10%" scope="row">
                        Key/Path:
                    </td>
                    <td>
                        <input type="text" name="updateKey" id="updateKey">
                    </td>
                </tr>
                <tr>
                    <td width="10%" scope="row">
                        Value:
                    </td>
                    <td>
                        <input type="text" name="updateValue" id="updateValue">
                    </td>
                </tr>
                <tr>
                    <td width="10%" scope="row">
                        Password - Special password required to update the field:
                    </td>
                    <td>
                        <input type="password" name="updatePassword" id="updatePassword">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br/>

                        <div style="color: red; font-weight: bold;">
                            Note: Updates can be potentially dangerous and could logout users! Please do it only if you know what you're doing!
                        </div>

                        <br/>

                        <input type="submit" value="Update Configuration" id="update-config"
                               onclick="this.form.type.value = 'updateConfig'; return confirm('Are you sure you want to update config?');">
                    </td>
                </tr>
                <tr>
                    <td colspan=2 id="updateResults" style="font-weight: bold; display: none;"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</form>

<script type='text/javascript'>
    $("#configForm").submit(function(event) {

        /* stop form from submitting normally */
        event.preventDefault();

        var $form = $(this),
            url = $form.attr('action');

        var $dest;
        if($("#searchType").val() == "searchConfig") {
            $("#searchResults").show();
            $dest = $("#searchResults > pre");
        } else if($("#searchType").val() == "updateConfig") {
            $dest = $("#updateResults");
            if(!$("#updatePassword").val()) {
                $dest.show().html("Password is invalid");
                return;
            }
        }

        $dest.show().html("Please wait...");

        /* Send the data using post with element id name and name2*/
        var posting = $.post(url, $form.serialize());

        // Clear the password
        $("#updatePassword").val("");

        /* Alerts the results */
        posting.done(function(data) {
            $dest.html(data);
        });
    });
</script>

<!-- END: main -->