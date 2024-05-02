<form id="auto_submit" action="{{ $redirect_uri }}" method="POST">
    <input type="hidden" name="id_token" value="{{ $jwt }}" />
    <input type="hidden" name="state" value="{{ $state }}" />
</form>
<script>
    document.getElementById('auto_submit').submit();
</script>