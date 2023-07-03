<div class="container">
    <a href="/logout">Logout</a>
    <h2>Test Location</h2>
    <form action="" method="POST">
        @csrf

        <div class="row">
            <div class="col-sm-3">
                <label>Location</label><br>
                <input type="text" name="location" id="location" required>
            </div>
            <div class="col-sm-3">
                <label>Client Name</label><br>
                <input type="text" name="name" placeholder="Client Name" required>
            </div>
            <div class="col-sm-3">
                <label>Meeting Time duration</label><br>
                <input type="number" name="time" placeholder="Meeting Time (in Minutes)" required>
                <span></span>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <input type="submit" class="btn btn-primary">
            </div>
        </div>
    </form>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBY5p5e5PtJuJLl_nRpjefL0S094jdhEP8&libraries=places"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        var autocomplete;
        var to = 'location';
        autocomplete = new google.maps.places.Autocomplete(document.getElementById(to), {
            types: ['geocode']
        });
    });
</script>
