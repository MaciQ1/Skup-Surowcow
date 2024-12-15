<footer class="container-fluid bg-body-tertiary {{ $fixedBottom ?? 'fixed-bottom' }}">
    <div class="row text-center pt-2">
        <p>&copy; Skup surowców &ndash; 2024</p>
    </div>
  </footer>

<script>
    window.onload = function(e){
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        var toastList = toastElList.map(function(toastEl) {
        return new bootstrap.Toast(toastEl)
  })
  toastList.forEach(toast => toast.show())
}
</script>
