<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
  <?php if (isset($article) && $article): ?>
    <div class="article-header mb-4">
      <div class="container">
        <h1 class="display-5"><?= htmlspecialchars($article['titre']) ?></h1>
        <p class="lead">
          <?= date('d/m/Y à H:i', strtotime($article['dateCreation'])) ?>
          <?php if (isset($categorie) && $categorie): ?>
            <span class="badge bg-info text-dark ms-2"><?= htmlspecialchars($categorie) ?></span>
          <?php endif; ?>
        </p>
      </div>
    </div>

    <div class="article-content">
      <div class="article-text">
        <?= nl2br(htmlspecialchars($article['contenu'])) ?>
      </div>
      
      <div class="article-actions mt-4">
        <a href="index.php" class="btn btn-secondary">
          <i class="bi bi-arrow-left"></i> Retour à l'accueil
        </a>
        
        <!-- Boutons d'administration (optionnels) -->
        <div class="admin-actions mt-3">
          <a href="edit-article.php?id=<?= $article['id'] ?>" class="btn btn-outline-warning btn-sm">
            <i class="bi bi-pencil"></i> Modifier
          </a>
          <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete(<?= $article['id'] ?>)">
            <i class="bi bi-trash"></i> Supprimer
          </button>
        </div>
      </div>
    </div>

  <?php else: ?>
    <div class="alert alert-danger">
      <h4>Article non trouvé</h4>
      <p>L'article que vous recherchez n'existe pas ou a été supprimé.</p>
    </div>
    <a href="index.php" class="btn btn-secondary">Retour à l'accueil</a>
  <?php endif; ?>
</div>

<script>
function confirmDelete(articleId) {
  if (confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
    window.location.href = 'delete-article.php?id=' + articleId;
  }
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

