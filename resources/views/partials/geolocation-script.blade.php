<script>
    (function () {
        if (!('geolocation' in navigator)) {
            return;
        }

        const storageKey = 'kb_nearby_location_sent';
        if (sessionStorage.getItem(storageKey)) {
            return;
        }

        const endpoint = @json(route('location.set'));
        const csrfToken = @json(csrf_token());

        function markLocationSent() {
            sessionStorage.setItem(storageKey, '1');
        }

        navigator.geolocation.getCurrentPosition(
            function (position) {
                if (!position?.coords) {
                    return;
                }

                fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                    }),
                })
                .then(function (response) {
                    if (response.ok) {
                        markLocationSent();
                    }
                })
                .catch(markLocationSent);
            },
            markLocationSent,
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 600000,
            }
        );
    })();
</script>
