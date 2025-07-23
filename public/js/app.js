// Application JavaScript pour le site d'actualités

document.addEventListener('DOMContentLoaded', function() {
    // Initialisation de l'application
    initializeApp();
});

function initializeApp() {
    // Gestion des alertes auto-dismiss
    initializeAlerts();
    
    // Gestion des animations
    initializeAnimations();
    
    // Gestion des formulaires
    initializeForms();
    
    // Gestion de la navigation
    initializeNavigation();
}

/**
 * Initialise la gestion des alertes
 */
function initializeAlerts() {
    // Auto-dismiss des alertes après 5 secondes
    const alerts = document.querySelectorAll('.alert:not(.alert-danger)');
    alerts.forEach(alert => {
        if (!alert.querySelector('.btn-close')) {
            setTimeout(() => {
                fadeOut(alert);
            }, 5000);
        }
    });
}

/**
 * Initialise les animations
 */
function initializeAnimations() {
    // Animation d'apparition des cartes d'articles
    const articles = document.querySelectorAll('.card-article');
    articles.forEach((article, index) => {
        article.style.animationDelay = `${index * 0.1}s`;
    });

    // Effet de survol sur les boutons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}

/**
 * Initialise la gestion des formulaires
 */
function initializeForms() {
    // Validation en temps réel
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
        
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                clearFieldError(this);
            });
        });
    });

    // Confirmation avant suppression
    const deleteButtons = document.querySelectorAll('[data-action="delete"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const itemName = this.dataset.itemName || 'cet élément';
            if (confirm(`Êtes-vous sûr de vouloir supprimer ${itemName} ?`)) {
                window.location.href = this.href;
            }
        });
    });
}

/**
 * Initialise la navigation
 */
function initializeNavigation() {
    // Gestion du retour en arrière
    const backButtons = document.querySelectorAll('[data-action="back"]');
    backButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            history.back();
        });
    });

    // Mise en évidence de la catégorie active
    const categoryLinks = document.querySelectorAll('.category-nav a');
    categoryLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Retirer la classe active de tous les liens
            categoryLinks.forEach(l => l.classList.remove('active'));
            // Ajouter la classe active au lien cliqué
            this.classList.add('active');
        });
    });
}

/**
 * Valide un champ de formulaire
 */
function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.getAttribute('name');
    let isValid = true;
    let errorMessage = '';

    // Validation selon le type de champ
    switch(fieldName) {
        case 'titre':
            if (value.length < 5) {
                isValid = false;
                errorMessage = 'Le titre doit contenir au moins 5 caractères.';
            }
            break;
            
        case 'contenu':
            if (value.length < 20) {
                isValid = false;
                errorMessage = 'Le contenu doit contenir au moins 20 caractères.';
            }
            break;
            
        case 'categorie':
            if (!value) {
                isValid = false;
                errorMessage = 'Veuillez sélectionner une catégorie.';
            }
            break;
    }

    // Affichage de l'erreur
    if (!isValid) {
        showFieldError(field, errorMessage);
    } else {
        clearFieldError(field);
    }

    return isValid;
}

/**
 * Affiche une erreur sur un champ
 */
function showFieldError(field, message) {
    clearFieldError(field);
    
    field.classList.add('is-invalid');
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'invalid-feedback';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

/**
 * Efface l'erreur d'un champ
 */
function clearFieldError(field) {
    field.classList.remove('is-invalid');
    
    const errorDiv = field.parentNode.querySelector('.invalid-feedback');
    if (errorDiv) {
        errorDiv.remove();
    }
}

/**
 * Effet de fondu pour faire disparaître un élément
 */
function fadeOut(element) {
    element.style.transition = 'opacity 0.5s ease-out';
    element.style.opacity = '0';
    
    setTimeout(() => {
        element.remove();
    }, 500);
}

/**
 * Affiche une notification toast
 */
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} position-fixed`;
    toast.style.cssText = `
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        animation: slideInRight 0.3s ease-out;
    `;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        fadeOut(toast);
    }, 3000);
}

/**
 * Gestion du chargement des images
 */
function handleImageLoading() {
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('error', function() {
            this.src = 'public/images/no-image.png';
            this.alt = 'Image non disponible';
        });
    });
}

// Initialiser le chargement des images
document.addEventListener('DOMContentLoaded', handleImageLoading);

// Gestion des erreurs JavaScript globales
window.addEventListener('error', function(e) {
    console.error('Erreur JavaScript:', e.error);
    // En production, vous pourriez envoyer cette erreur à un service de logging
});

// Utilitaires pour l'API (si nécessaire pour des fonctionnalités futures)
const API = {
    /**
     * Effectue une requête GET
     */
    get: async function(url) {
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error('Erreur API GET:', error);
            throw error;
        }
    },

    /**
     * Effectue une requête POST
     */
    post: async function(url, data) {
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return await response.json();
        } catch (error) {
            console.error('Erreur API POST:', error);
            throw error;
        }
    }
};

// Export pour utilisation dans d'autres scripts
window.AppUtils = {
    showToast,
    validateField,
    fadeOut,
    API
};

