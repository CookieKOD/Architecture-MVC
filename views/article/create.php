<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title mb-0">Créer un nouvel article</h3>
        </div>
        <div class="card-body">
          <form action="create-article.php" method="POST">
            <div class="mb-3">
              <label for="titre" class="form-label">Titre de l'article *</label>
              <input type="text" class="form-control" id="titre" name="titre" required 
                     placeholder="Saisissez le titre de votre article">
            </div>

            <div class="mb-3">
              <label for="categorie" class="form-label">Catégorie *</label>
              <select class="form-select" id="categorie" name="categorie" required>
                <option value="">Sélectionnez une catégorie</option>
                <?php if (isset($categories) && is_array($categories)): ?>
                  <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['libelle']) ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="contenu" class="form-label">Contenu de l'article *</label>
              <textarea class="form-control" id="contenu" name="contenu" rows="10" required
                        placeholder="Rédigez le contenu de votre article..."></textarea>
            </div>

            <div class="d-flex justify-content-between">
              <a href="index.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Annuler
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Publier l'article
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Validation côté client
document.querySelector('form').addEventListener('submit', function(e) {
  const titre = document.getElementById('titre').value.trim();
  const contenu = document.getElementById('contenu').value.trim();
  const categorie = document.getElementById('categorie').value;

  if (!titre || !contenu || !categorie) {
    e.preventDefault();
    alert('Veuillez remplir tous les champs obligatoires.');
    return false;
  }

  if (titre.length < 5) {
    e.preventDefault();
    alert('Le titre doit contenir au moins 5 caractères.');
    return false;
  }

  if (contenu.length < 20) {
    e.preventDefault();
    alert('Le contenu doit contenir au moins 20 caractères.');
    return false;
  }
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

