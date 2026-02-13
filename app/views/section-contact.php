<?php
use App\Security;
?>
<section id="contact" class="py-20 bg-rito-black">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 text-white">Contacto</h2>
                <p class="text-xl text-gray-300">
                    ¿Interesado en contratarnos? ¡Contáctanos!
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-12">
                <!-- Formulario -->
                <div>
                    <form id="contactForm" method="POST" action="<?= url('contact.php') ?>" class="space-y-6">
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nombre *</label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   required 
                                   class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white placeholder-gray-400 focus:border-rito-red focus:ring-1 focus:ring-rito-red focus:outline-none transition-colors duration-300"
                                   placeholder="Tu nombre completo">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email *</label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   required 
                                   class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white placeholder-gray-400 focus:border-rito-red focus:ring-1 focus:ring-rito-red focus:outline-none transition-colors duration-300"
                                   placeholder="tu@email.com">
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-300 mb-2">Asunto *</label>
                            <input type="text" 
                                   id="subject" 
                                   name="subject" 
                                   required 
                                   class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white placeholder-gray-400 focus:border-rito-red focus:ring-1 focus:ring-rito-red focus:outline-none transition-colors duration-300"
                                   placeholder="Motivo del contacto">
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-300 mb-2">Mensaje *</label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="5" 
                                      required 
                                      class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white placeholder-gray-400 focus:border-rito-red focus:ring-1 focus:ring-rito-red focus:outline-none transition-colors duration-300 resize-none"
                                      placeholder="Cuéntanos sobre tu evento, fecha, lugar, etc. (mínimo 10 caracteres)"></textarea>
                        </div>
                        
                    <!-- Captcha Matemático Simple -->
                    <div class="flex justify-center">
                        <div class="bg-gray-800 p-4 rounded-lg border border-gray-600">
                            <?php
                            $num1 = rand(1, 10);
                            $num2 = rand(1, 10);
                            $question = "$num1 + $num2";
                            ?>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Verificación: ¿Cuánto es <?= $num1 ?> + <?= $num2 ?>?
                            </label>
                            <input type="number" 
                                   name="captcha_answer" 
                                   required 
                                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:border-rito-red focus:ring-1 focus:ring-rito-red focus:outline-none"
                                   placeholder="Respuesta">
                            <input type="hidden" name="captcha_question" value="<?= $question ?>">
                        </div>
                    </div>
                        
                        <button type="submit" 
                                class="w-full bg-rito-red hover:bg-rito-red-dark text-white px-8 py-4 rounded-2xl font-semibold transition-all duration-300 transform hover:scale-105 neon-glow">
                            Enviar Mensaje
                        </button>
                    </form>
                    
                    <!-- Messages -->
                    <div id="formMessages" class="mt-6 hidden">
                        <div id="successMessage" class="hidden bg-green-900 border border-green-700 text-green-300 px-4 py-3 rounded-xl">
                            ¡Mensaje enviado correctamente! Te contactaremos pronto.
                        </div>
                        <div id="errorMessage" class="hidden bg-red-900 border border-red-700 text-red-300 px-4 py-3 rounded-xl">
                            Error al enviar el mensaje. Inténtalo más tarde.
                        </div>
                    </div>
                </div>
                
                <!-- Información de contacto -->
                <div class="space-y-8">
                    <div>
                        <h3 class="text-2xl font-bold text-white mb-6">Información</h3>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <svg class="w-6 h-6 text-rito-red mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <p class="text-gray-300">Email de contacto</p>
                                    <p class="text-white font-semibold">ritostereo@gmail.com</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <svg class="w-6 h-6 text-rito-red mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-gray-300">Tiempo de respuesta</p>
                                    <p class="text-white font-semibold">24-48 horas</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <svg class="w-6 h-6 text-rito-red mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-gray-300">Zona de actuación</p>
                                    <p class="text-white font-semibold">Argentina y países limítrofes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-900 rounded-2xl p-6">
                        <h4 class="text-xl font-bold text-white mb-4">¿Qué incluye nuestro show?</h4>
                        <ul class="space-y-2 text-gray-300">
                            <li class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-rito-red" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Repertorio completo de Soda Stereo</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-rito-red" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Equipamiento de sonido profesional</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-rito-red" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Iluminación y efectos visuales</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-rito-red" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Duración: 90-120 minutos</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
// Esperar a que el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    if (!form) {
        console.error('Formulario de contacto no encontrado');
        return;
    }
    
    console.log('Formulario de contacto encontrado, agregando listener...');
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        console.log('Formulario enviado');
        
        // Verificar que el captcha esté completado
        const captchaAnswer = document.querySelector('[name="captcha_answer"]');
        if (!captchaAnswer || !captchaAnswer.value) {
            alert('Por favor, resuelve la operación matemática antes de enviar el formulario.');
            return;
        }
        
        // Verificar longitud del mensaje
        const messageField = document.querySelector('[name="message"]');
        if (!messageField || messageField.value.length < 10) {
            alert('El mensaje debe tener al menos 10 caracteres.');
            return;
        }
        
        const formData = new FormData(this);
        const messagesDiv = document.getElementById('formMessages');
        const successDiv = document.getElementById('successMessage');
        const errorDiv = document.getElementById('errorMessage');
        
        // Hide previous messages
        successDiv.classList.add('hidden');
        errorDiv.classList.add('hidden');
        messagesDiv.classList.add('hidden');
        
        try {
            console.log('Enviando formulario...');
            const response = await fetch(this.action, {
                method: 'POST',
                body: formData
            });
            
            console.log('Respuesta recibida:', response.status);
            const result = await response.json();
            console.log('Resultado:', result);
            
            messagesDiv.classList.remove('hidden');
            
            if (result.success) {
                successDiv.classList.remove('hidden');
                this.reset();
                // Reset captcha
                if (typeof grecaptcha !== 'undefined') {
                    grecaptcha.reset();
                }
            } else {
                errorDiv.classList.remove('hidden');
                if (result.errors) {
                    errorDiv.innerHTML = result.errors.join('<br>');
                }
                // Reset captcha on error
                if (typeof grecaptcha !== 'undefined') {
                    grecaptcha.reset();
                }
            }
        } catch (error) {
            console.error('Error:', error);
            messagesDiv.classList.remove('hidden');
            errorDiv.classList.remove('hidden');
            errorDiv.textContent = 'Error de conexión. Inténtalo más tarde.';
            // Reset captcha on error
            if (typeof grecaptcha !== 'undefined') {
                grecaptcha.reset();
            }
        }
    });
});
</script>
