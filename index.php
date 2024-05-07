<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulário de Envio de Currículos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    .custom-card {
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      padding: 20px;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="card custom-card">
      <div class="card-body">
        <h1 class="card-title mb-4">Formulário de Envio de Currículos</h1>
        <form action="backend/processar_formulario.php" method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="nome" class="form-label">Nome:</label>
              <input type="text" id="nome" name="nome" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="email" class="form-label">E-mail:</label>
              <input type="email" id="email" name="email" class="form-control" required>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="telefone" class="form-label">Telefone:</label>
              <input type="tel" id="telefone" name="telefone" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="cargo" class="form-label">Cargo Desejado:</label>
              <input type="text" id="cargo" name="cargo" class="form-control" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="escolaridade" class="form-label">Escolaridade:</label>
            <select id="escolaridade" name="escolaridade" class="form-select" required>
              <option value="">Selecione...</option>
              <option value="fundamental">Fundamental</option>
              <option value="medio">Médio</option>
              <option value="superior">Superior</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="observacoes" class="form-label">Observações:</label>
            <textarea id="observacoes" name="observacoes" class="form-control"></textarea>
          </div>

          <div class="mb-3">
            <label for="arquivo" class="form-label">Currículo (PDF ou Word, até 1MB):</label>
            <input type="file" id="arquivo" name="arquivo" accept=".pdf, .doc, .docx" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
