<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="banner">
  <h1>Bienvenue Actualités - M1 IABD</h1>
  <p>Suivez les dernières actualités du moment</p>
</div>

<div class="container">
  <!-- Navbar Catégories -->
  <div class="category-nav mb-4">
    <a href="index.php" class="btn btn-outline-primary <?= $categorieId === 0 ? 'active' : '' ?>">Découvrir</a>
    <?php if (isset($categories) && is_array($categories)): ?>
      <?php foreach ($categories as $cat): ?>
        <a href="index.php?categorie=<?= $cat['id'] ?>" class="btn btn-outline-primary <?= $categorieId === intval($cat['id']) ? 'active' : '' ?>">
          <?= htmlspecialchars($cat['libelle']) ?>
        </a>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <!-- Messages de succès -->
  <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      Article créé avec succès !
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <!-- Articles -->
  <?php if (isset($articles) && is_array($articles) && count($articles) > 0): ?>
    <?php foreach ($articles as $article): ?>
      <div class="card mb-4 card-article">
        <div class="card-body">
          <h4 class="card-title"><?= htmlspecialchars($article['titre']) ?></h4>
          <p class="card-subtitle text-muted mb-2">
            <?= date('d/m/Y à H:i', strtotime($article['dateCreation'])) ?>
          </p>
          <p class="card-text">
            <?= nl2br(substr(htmlspecialchars($article['contenu']), 0, 200)) ?>...
          </p>
          <a href="article.php?id=<?= $article['id'] ?>" class="btn btn-sm btn-lire">Lire la suite</a>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div style="text-align: center; margin-top: 50px;">
      <img src="public/images/no-results.png" alt="Pas d'articles" style="width: 150px; opacity: 0.8;">
      <p style="font-size: 18px; color: #555;">Pas d'articles pour le moment.</p>
    </div>
  <?php endif; ?>

  <!-- Bouton pour créer un article -->
  <div class="text-center mt-4 mb-4">
    <a href="create-article.php" class="btn btn-success">
      <i class="bi bi-plus-circle"></i> Créer un nouvel article
    </a>
  </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

