<?php $__env->startSection('title', 'تسجيل الدخول | دليل الأطباء'); ?>

<?php $__env->startSection('content'); ?>

<div class="doctor-login-page">

    <div class="doctor-login-bg-circle doctor-login-circle-one"></div>
    <div class="doctor-login-bg-circle doctor-login-circle-two"></div>
    <div class="doctor-login-bg-circle doctor-login-circle-three"></div>




    
    <main class="doctor-login-main">

        <div class="doctor-login-wrapper">


            
            <section class="doctor-login-hero">

                <div class="doctor-login-hero-content">


                    <div class="doctor-login-online-badge">

                        <span class="doctor-login-online-dot"></span>

                        منصتك الطبية الموثوقة

                    </div>


                    <div class="doctor-login-hero-title">

                        <h1>
                            اكتشف عالمًا
                            <br>
                            <span>من الرعاية الأفضل</span>
                        </h1>

                        <p>
                            سجّل دخولك للوصول إلى حسابك،
                            متابعة مواعيدك، وإدارة تجربتك
                            الطبية بسهولة وأمان.
                        </p>

                    </div>


                    
                    <div class="doctor-login-medical-visual">

                        <div class="doctor-login-visual-ring"></div>

                        <div class="doctor-login-visual-ring-two"></div>


                        <div class="doctor-login-floating-icon doctor-login-floating-one">

                            <svg viewBox="0 0 24 24" fill="none">

                                <path d="M12 21C12 21 19 17.5 19 11V5.5L12 3L5 5.5V11C5 17.5 12 21 12 21Z"
                                      stroke="currentColor"
                                      stroke-width="1.6"/>

                                <path d="M9 12L11 14L15.5 9.5"
                                      stroke="currentColor"
                                      stroke-width="1.6"
                                      stroke-linecap="round"/>

                            </svg>

                        </div>


                        <div class="doctor-login-floating-icon doctor-login-floating-two">

                            <svg viewBox="0 0 24 24" fill="none">

                                <path d="M4 12H8L10 5L14 19L16 12H20"
                                      stroke="currentColor"
                                      stroke-width="1.7"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"/>

                            </svg>

                        </div>


                        <div class="doctor-login-floating-icon doctor-login-floating-three">

                            <svg viewBox="0 0 24 24" fill="none">

                                <circle cx="12"
                                        cy="12"
                                        r="8"
                                        stroke="currentColor"
                                        stroke-width="1.6"/>

                                <path d="M12 8V12L15 14"
                                      stroke="currentColor"
                                      stroke-width="1.6"
                                      stroke-linecap="round"/>

                            </svg>

                        </div>


                        <div class="doctor-login-medical-card">

                            <div class="doctor-login-medical-cross">

                                <svg viewBox="0 0 24 24" fill="none">

                                    <path d="M12 4V20"
                                          stroke="currentColor"
                                          stroke-width="2.4"
                                          stroke-linecap="round"/>

                                    <path d="M4 12H20"
                                          stroke="currentColor"
                                          stroke-width="2.4"
                                          stroke-linecap="round"/>

                                </svg>

                            </div>

                        </div>

                    </div>


                    
                    <div class="doctor-login-hero-stats">

                        <div class="doctor-login-stat">

                            <strong>+1K</strong>

                            <span>
                                طبيب موثوق
                            </span>

                        </div>


                        <div class="doctor-login-stat">

                            <strong>+50K</strong>

                            <span>
                                مريض
                            </span>

                        </div>


                        <div class="doctor-login-stat">

                            <strong>24/24</strong>

                            <span>
                                دعم مستمر
                            </span>

                        </div>

                    </div>

                </div>

            </section>


            
            <section class="doctor-login-form-panel">

                <div class="doctor-login-form-container">


                    <div class="doctor-login-welcome">

                        <div class="doctor-login-welcome-icon">

                            <svg viewBox="0 0 24 24" fill="none">

                                <path d="M4 19C4 15.13 7.13 12 11 12H13C16.87 12 20 15.13 20 19"
                                      stroke="currentColor"
                                      stroke-width="1.7"
                                      stroke-linecap="round"/>

                                <circle cx="12"
                                        cy="6.5"
                                        r="3.5"
                                        stroke="currentColor"
                                        stroke-width="1.7"/>

                            </svg>

                        </div>


                        <h2>
                            أهلًا بعودتك 👋
                        </h2>


                        <p>
                            سجّل دخولك إلى حسابك واستكمل
                            رحلتك معنا.
                        </p>

                    </div>


                    <form
                        method="POST"
                        action="<?php echo e(route('login')); ?>"
                        id="doctorLoginForm">

                        <?php echo csrf_field(); ?>


                        
                        <div class="doctor-login-field">

                            <label for="doctorLoginEmail">
                                البريد الإلكتروني
                            </label>

                            <div class="doctor-login-input">

                                <span class="doctor-login-input-icon">

                                    <svg viewBox="0 0 24 24" fill="none">

                                        <rect x="3"
                                              y="5"
                                              width="18"
                                              height="14"
                                              rx="2"
                                              stroke="currentColor"
                                              stroke-width="1.7"/>

                                        <path d="M3 7L10.2 12.2C11.27 12.97 12.73 12.97 13.8 12.2L21 7"
                                              stroke="currentColor"
                                              stroke-width="1.7"
                                              stroke-linecap="round"/>

                                    </svg>

                                </span>


                                <input
                                    type="email"
                                    id="doctorLoginEmail"
                                    name="email"
                                    value="<?php echo e(old('email')); ?>"
                                    placeholder="example@email.com"
                                    autocomplete="email"
                                    required
                                    oninput="this.value = this.value.toLowerCase()"
                                    autofocus>

                            </div>

                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="doctor-register-auth-error">
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        </div>


                        
                        <div class="doctor-login-field">

                            <label for="doctorLoginPassword">
                                كلمة المرور
                            </label>

                            <div class="doctor-login-input">

                                <span class="doctor-login-input-icon">

                                    <svg viewBox="0 0 24 24" fill="none">

                                        <rect x="5"
                                              y="10"
                                              width="14"
                                              height="10"
                                              rx="2"
                                              stroke="currentColor"
                                              stroke-width="1.7"/>

                                        <path d="M8 10V7.5C8 5.29 9.79 3.5 12 3.5C14.21 3.5 16 5.29 16 7.5V10"
                                              stroke="currentColor"
                                              stroke-width="1.7"/>

                                    </svg>

                                </span>


                                <input
                                    type="password"
                                    id="doctorLoginPassword"
                                    name="password"
                                    placeholder="أدخل كلمة المرور"
                                    autocomplete="current-password"
                                    required>


                                <button
                                    type="button"
                                    class="doctor-login-password-toggle"
                                    id="doctorLoginTogglePassword"
                                    aria-label="إظهار كلمة المرور">

                                    <svg viewBox="0 0 24 24" fill="none">

                                        <path d="M2.5 12C4.5 8 8 6 12 6C16 6 19.5 8 21.5 12C19.5 16 16 18 12 18C8 18 4.5 16 2.5 12Z"
                                              stroke="currentColor"
                                              stroke-width="1.6"/>

                                        <circle cx="12"
                                                cy="12"
                                                r="2.5"
                                                stroke="currentColor"
                                                stroke-width="1.6"/>

                                    </svg>

                                </button>

                            </div>

                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="doctor-register-auth-error">
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        </div>


                        
                        <div class="doctor-login-options">

                            <label class="doctor-login-remember">

                                <input
                                    type="checkbox"
                                    id="doctorLoginRemember"
                                    name="remember">

                                <span class="doctor-login-check">

                                    <svg viewBox="0 0 24 24" fill="none">

                                        <path d="M5 12.5L10 17L19 7"
                                              stroke="currentColor"
                                              stroke-width="2"
                                              stroke-linecap="round"
                                              stroke-linejoin="round"/>

                                    </svg>

                                </span>

                                تذكرني

                            </label>


                            <a
                                href="<?php echo e(route('password.request')); ?>"
                                class="doctor-login-forgot">

                                نسيت كلمة المرور؟

                            </a>

                        </div>


                        
                        <button
                            type="submit"
                            class="doctor-login-button">

                            تسجيل الدخول

                            <svg viewBox="0 0 24 24" fill="none">

                                <path d="M5 12H19"
                                      stroke="currentColor"
                                      stroke-width="1.8"
                                      stroke-linecap="round"/>

                                <path d="M13 6L19 12L13 18"
                                      stroke="currentColor"
                                      stroke-width="1.8"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"/>

                            </svg>

                        </button>

                    </form>


                    <div class="doctor-login-divider">
                        أو
                    </div>


                    <div class="doctor-login-create-account">

                        ليس لديك حساب حتى الآن؟

                        <a href="<?php echo e(route('register')); ?>">
                            إنشاء حساب جديد
                        </a>

                    </div>


                    <div class="doctor-login-secure-note">

                        <svg viewBox="0 0 24 24" fill="none">

                            <path d="M12 21C12 21 19 17.5 19 11V5.5L12 3L5 5.5V11C5 17.5 12 21 12 21Z"
                                  stroke="currentColor"
                                  stroke-width="1.7"
                                  stroke-linejoin="round"/>

                            <path d="M9 12L11 14L15 10"
                                  stroke="currentColor"
                                  stroke-width="1.7"
                                  stroke-linecap="round"/>

                        </svg>

                        بياناتك محمية ومشفرة بشكل آمن

                    </div>


                </div>

            </section>

        </div>

    </main>




</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('home.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/auth/login.blade.php ENDPATH**/ ?>