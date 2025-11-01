<?php
/**
 * Plugin Name: Avertissement Démo - Modal
 * Description: Affiche un modal d'avertissement sur toutes les pages indiquant que le site est une démonstration
 * Version: 1.0.0
 * Author: Équipe du projet
 */

// Empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

class Demo_Notice_Modal {
    
    public function __construct() {
        // Ajouter le modal uniquement sur le front-end (pas dans l'admin)
        if (!is_admin()) {
            add_action('wp_footer', array($this, 'render_modal'));
            add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
        }
    }
    
    /**
     * Ajouter les styles CSS pour le modal
     */
    public function enqueue_styles() {
        ?>
        <style id="demo-notice-modal-styles">
            /* Overlay du modal */
            #demo-notice-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.7);
                z-index: 999999;
                align-items: center;
                justify-content: center;
                animation: fadeIn 0.3s ease-in-out;
            }
            
            #demo-notice-overlay.show {
                display: flex;
            }
            
            /* Contenu du modal */
            #demo-notice-modal {
                background: #fff;
                border-radius: 12px;
                padding: 40px;
                max-width: 600px;
                width: 90%;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
                text-align: center;
                position: relative;
                animation: slideUp 0.3s ease-out;
            }
            
            /* Titre du modal */
            #demo-notice-modal h2 {
                margin: 0 0 20px 0;
                color: #333;
                font-size: 24px;
                font-weight: 600;
            }
            
            /* Message du modal */
            #demo-notice-modal p {
                margin: 0 0 30px 0;
                color: #666;
                font-size: 16px;
                line-height: 1.6;
            }
            
            /* Bouton "J'ai compris" */
            #demo-notice-btn {
                background-color: #4A9278;
                color: #fff;
                border: none;
                padding: 12px 30px;
                font-size: 16px;
                font-weight: 600;
                border-radius: 6px;
                cursor: pointer;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-block;
                margin-bottom: 15px;
            }
            
            #demo-notice-btn:hover {
                background-color: #3a7560;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(74, 146, 120, 0.3);
            }
            
            #demo-notice-btn:active {
                transform: translateY(0) scale(0.98);
                box-shadow: 0 2px 4px rgba(74, 146, 120, 0.2);
            }
            
            /* Lien vers l'événement */
            #demo-notice-link {
                display: block;
                margin-top: 15px;
                color: #4A9278;
                text-decoration: none;
                font-size: 14px;
                transition: color 0.3s ease;
            }
            
            #demo-notice-link:hover {
                color: #3a7560;
                text-decoration: underline;
            }
            
            /* Animation fade in */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }
            
            /* Animation slide up */
            @keyframes slideUp {
                from {
                    transform: translateY(30px);
                    opacity: 0;
                }
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }
            
            /* Responsive */
            @media (max-width: 768px) {
                #demo-notice-modal {
                    padding: 30px 20px;
                }
                
                #demo-notice-modal h2 {
                    font-size: 20px;
                }
                
                #demo-notice-modal p {
                    font-size: 14px;
                }
            }
        </style>
        <?php
    }
    
    /**
     * Afficher le modal dans le footer
     */
    public function render_modal() {
        ?>
        <div id="demo-notice-overlay">
            <div id="demo-notice-modal">
                <h2>Avertissement</h2>
                <p>Ce site est une démonstration à destination des écuries du Pouey, ce n'est pas le véritable site web des écuries.</p>
                <p>Ce site web a été fait par notre équipe d'étudiants dans le cadre du Hackathon transdisciplinaire des "Ymmersion" (école Ynov).</p>
                <button id="demo-notice-btn">J'ai compris</button>
                <a href="https://www.ynov.com/campus/connect/actualites/rentree-2024-resultats-ymmersion-ecuries-du-pouey" target="_blank" rel="noopener noreferrer" id="demo-notice-link">En savoir plus sur le projet Ymmersion</a>
            </div>
        </div>
        
        <script>
        (function() {
            // Vérifier si l'utilisateur a déjà fermé le modal
            var modalClosed = localStorage.getItem('demo-notice-closed');
            
            // Afficher le modal si ce n'est pas déjà fermé
            if (!modalClosed) {
                var overlay = document.getElementById('demo-notice-overlay');
                var modal = document.getElementById('demo-notice-modal');
                var btn = document.getElementById('demo-notice-btn');
                
                // Afficher le modal après un court délai pour une meilleure UX
                setTimeout(function() {
                    overlay.classList.add('show');
                    // Empêcher le scroll du body quand le modal est ouvert
                    document.body.style.overflow = 'hidden';
                }, 500);
                
                // Gérer le clic sur le bouton
                btn.addEventListener('click', function() {
                    // Sauvegarder dans localStorage que le modal a été fermé
                    localStorage.setItem('demo-notice-closed', 'true');
                    // Fermer le modal
                    overlay.classList.remove('show');
                    // Restaurer le scroll
                    document.body.style.overflow = '';
                });
                
                // Optionnel : fermer en cliquant sur l'overlay (extérieur du modal)
                overlay.addEventListener('click', function(e) {
                    if (e.target === overlay) {
                        localStorage.setItem('demo-notice-closed', 'true');
                        overlay.classList.remove('show');
                        document.body.style.overflow = '';
                    }
                });
            }
        })();
        </script>
        <?php
    }
}

// Initialiser le plugin
new Demo_Notice_Modal();

