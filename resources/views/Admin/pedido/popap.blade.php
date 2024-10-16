    <!-- Bootstrap CSS (opcional) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery (para capturar el evento del botón) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="container">
    <button type="button" class="btn btn-danger" id="btnVerDetalle">Ver detalle</button>
</div>

<style>
        /* Personalizar la posición del modal */
        .swal2-container {
            bottom: 0 !important;
            top: auto !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            box-sizing: border-box;
        }

        .swal2-popup {
            width: 100% !important;
            border-radius: 0 !important;
            margin: 0 !important;
            border: none !important;
        }
    </style>

<script>
    $(document).ready(function () {
        $('#btnVerDetalle').on('click', function () {
            Swal.fire({
                title: 'Detalles del pedido',
                text: 'Aquí van los detalles del pedido.',
                icon: 'info',
                showCloseButton: true,
                showConfirmButton: false,
                customClass: {
                    popup: 'my-swal-popup'
                }
            });
        });
    });
</script>