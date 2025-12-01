<!-- Modal -->
<div class="modal fade" id="sessionModal" tabindex="-1" aria-labelledby="sessionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sessionModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
      showModal('Success', '{{ session('success') }}', 'alert-success');
    @elseif(session('error'))
      showModal('Error', '{{ session('error') }}', 'alert-danger');
    @endif
  });

  function showModal(title, message, alertClass) {
    // Set the title and message of the modal
    document.getElementById('sessionModalLabel').textContent = title;
    document.querySelector('#sessionModal .modal-body').textContent = message;

    // Set the alert class for modal header
    document.querySelector('#sessionModal .modal-header').classList.add(alertClass);

    // Show the modal
    var sessionModal = new bootstrap.Modal(document.getElementById('sessionModal'));
    sessionModal.show();
  }
</script>
