<x-dashboard>

    <h3>{{ Auth::user()->username }}'s account</h3>
    <hr>

    <section id="load-tests">
        <h4>Change password</h4>
        <p>If you want to change your password, fill the form below:</p>
        <form id="change-password-form">
            @csrf

            <!-- Old Password -->
            <div>
                <input id="old-password" placeholder="Old password" type="password" name="password" required
                    autocomplete="new-password" />
            </div>

            <!-- New Password -->
            <div>
                <input id="new-password" placeholder="New password" type="password" name="new_password" required />
            </div>

            <!-- Confirm New Password -->
            <div>
                <input id="new-password-confirmation" placeholder="Repeat new password" type="password"
                    name="new_password_confirmation" required />
            </div>

            <button type="submit">Change password</button>
        </form>

    </section>

    <script>
        $("#change-password-form").submit(function(e) {
            e.preventDefault();
            var old_password = $('#old-password').val();
            var new_password = $('#new-password').val();
            var new_password_confirmation = $('#new-password-confirmation').val();

            if (new_password == new_password_confirmation && new_password != old_password) {
                $.ajax({
                    type: 'POST',
                    url: '/dashboard/account/change-password',
                    data: {
                        old_password: old_password,
                        new_password: new_password,
                        new_password_confirmation: new_password_confirmation
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.message) {
                            displayStatus(response.message);
                            $('#old-password').val('');
                            $('#new-password').val('');
                            $('#new-password-confirmation').val('');
                        } else {
                            displayStatus('Something went wrong. Didn\'t receive any reponse.')
                        }
                    },
                    error: function(result) {
                        displayStatus(result.error);
                    }
                });
            } else {
                displayStatus('Inserted passwords are not correct');
            }

        });

        function displayStatus(message) {
            $(document.body).append(
                "<div class='status status-active'><p>" + message + "</p></div>"
            );
        }
    </script>

</x-dashboard>
