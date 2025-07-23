<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card border-danger">
        <div class="card-header bg-danger text-white">
          <h4 class="card-title mb-0">
            <i class="bi bi-exclamation-triangle"></i> Erreur
          </h4>
        </div>
        <div class="card-body">
          <div class="alert alert-danger" role="alert">
            <?= isset($errorMessage) ? htmlspecialchars($errorMessage) : 'Une erreur inattendue s\'est produite.' ?>
          </div>
          
          <div class="text-center">
            <a href="index.php" class="btn btn-primary">
              <i class="bi bi-house"></i> Retour à l'accueil
            </a>
            <button onclick="history.back()" class="btn btn-secondary">
              <i class="bi bi-arrow-left"></i> Page précédente
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

