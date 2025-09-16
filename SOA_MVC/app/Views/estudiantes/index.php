<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Gestión de Estudiantes • Cliente MVC</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body { background: #f6f8fb; }
    .card { border: 0; box-shadow: 0 8px 28px rgba(0,0,0,.07); }
    .table thead th { position: sticky; top: 0; background: #fff; z-index: 1; }
    .table-hover tbody tr.selected { outline: 2px solid #0d6efd66; background: #eaf2ff; }
    .h-420 { height: 420px; }
    .table-scroll { max-height: 320px; overflow: auto; }
    .btn-icon { display: inline-flex; align-items: center; gap: .35rem; }
    .spinner-overlay{
      position: fixed; inset: 0; background: rgba(255,255,255,.7);
      display:none; place-items:center; z-index: 1055;
    }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-semibold" href="#">
        <i class="bi bi-diagram-3"></i> SOA • Cliente MVC
      </a>
      <div class="ms-auto small text-muted">
        <i class="bi bi-database"></i> MySQL · <i class="bi bi-lightning-charge"></i> API PHP
      </div>
    </div>
  </nav>

  <main class="container py-4">
    <div class="row g-4">
      <div class="col-lg-8">
        <div class="card h-100">
          <div class="card-header bg-white d-flex align-items-center justify-content-between">
            <div>
              <h5 class="card-title m-0">Estudiantes</h5>
              <div class="text-secondary small">Total: <span id="badgeTotal" class="badge text-bg-primary">0</span></div>
            </div>
            <div class="d-flex gap-2">
              <div class="input-group input-group-sm">
                <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                <input id="txtBuscar" type="search" class="form-control" placeholder="Buscar por nombre, apellido o cédula...">
              </div>
              <button id="btnRecargar" class="btn btn-sm btn-outline-primary btn-icon"><i class="bi bi-arrow-repeat"></i> Recargar</button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive table-scroll">
              <table class="table table-hover align-middle mb-0" id="tabla">
                <thead class="border-bottom">
                  <tr class="text-secondary">
                    <th style="min-width: 130px;">Cédula</th>
                    <th style="min-width: 160px;">Nombre</th>
                    <th style="min-width: 160px;">Apellido</th>
                    <th style="min-width: 220px;">Dirección</th>
                    <th style="min-width: 140px;">Teléfono</th>
                  </tr>
                </thead>
                <tbody id="tablaBody"><tr><td colspan="5" class="text-center text-secondary py-4">Cargando...</td></tr></tbody>
              </table>
            </div>
            <div class="form-text mt-2"><i class="bi bi-mouse3"></i> Haz clic en una fila para editarla.</div>
          </div>
        </div>
      </div>

      <!-- Formulario -->
      <div class="col-lg-4">
        <div class="card h-100">
          <div class="card-header bg-white">
            <h5 class="card-title m-0"><i class="bi bi-person-vcard"></i> Formulario</h5>
          </div>
          <div class="card-body">
            <form id="frm" class="needs-validation" novalidate>
              <div class="mb-3">
                <label class="form-label">Cédula <span class="text-danger">*</span></label>
                <input id="cedula" class="form-control" maxlength="10" required>
                <div class="invalid-feedback">La cédula es obligatoria.</div>
              </div>
              <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input id="nombre" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Apellido</label>
                <input id="apellido" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Dirección</label>
                <input id="direccion" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input id="telefono" class="form-control" type="tel">
              </div>
            </form>
          </div>
          <div class="card-footer bg-white d-grid gap-2">
            <div class="btn-group">
              <button id="btnCrear" class="btn btn-success btn-icon"><i class="bi bi-plus-circle"></i> Crear</button>
              <button id="btnActualizar" class="btn btn-primary btn-icon"><i class="bi bi-save"></i> Actualizar</button>
              <button id="btnEliminar" class="btn btn-danger btn-icon"><i class="bi bi-trash"></i> Eliminar</button>
            </div>
            <button id="btnLimpiar" class="btn btn-outline-secondary btn-icon"><i class="bi bi-eraser"></i> Limpiar</button>
          </div>
        </div>
      </div>
    </div>
  </main>

  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1056">
    <div id="toast" class="toast align-items-center text-bg-dark border-0" role="alert">
      <div class="d-flex">
        <div id="toastMsg" class="toast-body"></div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  </div>

  <div class="spinner-overlay" id="loading">
    <div class="spinner-border text-primary" role="status" aria-label="Cargando"></div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./js/app.js"></script>
</body>
</html>