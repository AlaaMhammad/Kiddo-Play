<aside id="layout-menu" class="layout-menu menu-vertical menu">
    <div class="app-brand demo">
        <a href="{{ route('admin.index') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <span class="text-primary">
                    <img src="{{ asset('dashboard/assets/img/kiddo.png') }}" alt="icon"
                        style="height: 50px; width: 50px; object-fit: contain;">
                </span>
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">{{ env('APP_NAME') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="icon-base bx bx-chevron-left"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ request()->routeIs('admin.index') ? 'active' : '' }}">
            <a href="{{ route('admin.index') }}" class="menu-link">
                <i class="menu-icon icon-base bx bx-home-smile"></i>
                <div data-i18n="Dashboards">{{ __('menu.dashboard') }}</div>
            </a>
        </li>

        {{-- فقط للأدمن: كل شيء --}}
        @if (auth()->user()->role?->name === 'admin')
            <li class="menu-header small text-uppercase"><span
                    class="menu-header-text">{{ __('menu.main_management_header') }}</span></li>
            <li
                class="menu-item {{ request()->is('admin/users*') || request()->is('admin/roles*') || request()->is('admin/avatars*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-user"></i>
                    <div data-i18n="Users & Roles">{{ __('menu.users_roles') }}</div>
                </a>
                <ul class="menu-sub">
                    {{-- Users --}}
                    <li
                        class="menu-item {{ request()->is('admin/users*') || request()->routeIs('admin.users.create') || request()->routeIs('admin.users.edit') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.index') }}" class="menu-link">
                            <div>{{ __('menu.view_all_users') }}</div>
                        </a>
                    </li>
                    {{-- Roles --}}
                    <li class="menu-item {{ request()->is('admin/roles*') ? 'active' : '' }}">
                        <a href="{{ route('admin.roles.index') }}" class="menu-link">
                            <div>{{ __('menu.roles_permissions') }}</div>
                        </a>
                    </li>
                    {{-- Avatars --}}
                    <li class="menu-item {{ request()->is('admin/avatars*') ? 'active' : '' }}">
                        <a href="{{ route('admin.avatars.index') }}" class="menu-link">
                            <div>{{ __('menu.avatars') }}</div>
                        </a>
                    </li>
                </ul>
            </li>


            <li class="menu-header small text-uppercase"><span
                    class="menu-header-text">{{ __('menu.kids_progress_header') }}</span></li>
            <li
                class="menu-item {{ request()->is('admin/kids*') || request()->is('admin/parent-children*') || request()->is('admin/kid-*') || request()->is('admin/otps*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-child"></i>
                    <div data-i18n="Kids Management">{{ __('menu.kids_management') }}</div>
                </a>
                <ul class="menu-sub">
                    {{-- Kids --}}
                    <li
                        class="menu-item {{ request()->routeIs('admin.kids.index') || request()->routeIs('admin.kids.create') || request()->routeIs('admin.kids.edit') ? 'active' : '' }}">
                        <a href="{{ route('admin.kids.index') }}" class="menu-link">
                            <div>{{ __('menu.kids_list') }}</div>
                        </a>
                    </li>
                    {{-- Parent-Children --}}
                    <li
                        class="menu-item {{ request()->routeIs('admin.parent-children.index') || request()->routeIs('admin.parent-children.create') ? 'active' : '' }}">
                        <a href="{{ route('admin.parent-children.index') }}" class="menu-link">
                            <div>{{ __('menu.parent_child_links') }}</div>
                        </a>
                    </li>
                    {{-- Kid Achievements --}}
                    <li
                        class="menu-item {{ request()->routeIs('admin.kid-achievements.index') || request()->routeIs('admin.kid-achievements.create') || request()->routeIs('admin.kid-achievements.edit') ? 'active' : '' }}">
                        <a href="{{ route('admin.kid-achievements.index') }}" class="menu-link">
                            <div>{{ __('menu.kid_achievements') }}</div>
                        </a>
                    </li>
                    {{-- Kid Lesson Progresses --}}
                    <li
                        class="menu-item {{ request()->routeIs('admin.kid-lesson-progresses.index') || request()->routeIs('admin.kid-lesson-progresses.create') || request()->routeIs('admin.kid-lesson-progresses.edit') ? 'active' : '' }}">
                        <a href="{{ route('admin.kid-lesson-progresses.index') }}" class="menu-link">
                            <div>{{ __('menu.lesson_progress') }}</div>
                        </a>
                    </li>
                    {{-- Kid Sessions --}}
                    <li
                        class="menu-item {{ request()->routeIs('admin.kid-sessions.index') || request()->routeIs('admin.kid-sessions.create') || request()->routeIs('admin.kid-sessions.edit') ? 'active' : '' }}">
                        <a href="{{ route('admin.kid-sessions.index') }}" class="menu-link">
                            <div>{{ __('menu.kid_sessions') }}</div>
                        </a>
                    </li>
                    {{-- OTPs --}}
                    <li
                        class="menu-item {{ request()->routeIs('admin.otps.index') || request()->routeIs('admin.otps.create') || request()->routeIs('admin.otps.edit') ? 'active' : '' }}">
                        <a href="{{ route('admin.otps.index') }}" class="menu-link">
                            <div>{{ __('menu.otps') }}</div>
                        </a>
                    </li>
                </ul>
            </li>


            <li class="menu-header small text-uppercase"><span
                    class="menu-header-text">{{ __('menu.games_goals_header') }}</span></li>

            <li
                class="menu-item {{ request()->is('admin/games*') || request()->is('admin/game-kids*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-game"></i>
                    <div data-i18n="Games">{{ __('menu.games') }}</div>
                </a>
                <ul class="menu-sub">
                    {{-- Games --}}
                    <li class="menu-item {{ request()->is('admin/games*') ? 'active' : '' }}">
                        <a href="{{ route('admin.games.index') }}" class="menu-link">
                            <div>{{ __('menu.games_list') }}</div>
                        </a>
                    </li>
                    {{-- Game Kids --}}
                    <li class="menu-item {{ request()->is('admin/game-kids*') ? 'active' : '' }}">
                        <a href="{{ route('admin.game-kids.index') }}" class="menu-link">
                            <div>{{ __('menu.kid_game_records') }}</div>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Daily Goals --}}
            <li class="menu-item {{ request()->is('admin/daily-goals*') ? 'active open' : '' }}">
                <a href="{{ route('admin.daily-goals.index') }}" class="menu-link">
                    <i class="menu-icon bx bx-target-lock"></i>
                    <div data-i18n="DailyGoals">{{ __('menu.daily_goals') }}</div>
                </a>
            </li>


            <li class="menu-header small text-uppercase"><span
                    class="menu-header-text">{{ __('menu.rewards_store_header') }}</span></li>

            {{-- Rewards --}}
            <li class="menu-item {{ request()->is('admin/rewards*') ? 'active open' : '' }}">
                <a href="{{ route('admin.rewards.index') }}" class="menu-link">
                    <i class="menu-icon bx bx-gift"></i>
                    <div data-i18n="Rewards">{{ __('menu.rewards') }}</div>
                </a>
            </li>

            <li
                class="menu-item {{ request()->is('admin/store-items*') || request()->is('admin/purchases*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-store"></i>
                    <div data-i18n="Store & Purchases">{{ __('menu.store_purchases') }}</div>
                </a>
                <ul class="menu-sub">
                    {{-- Store Items --}}
                    <li class="menu-item {{ request()->is('admin/store-items*') ? 'active' : '' }}">
                        <a href="{{ route('admin.store-items.index') }}" class="menu-link">
                            <div>{{ __('menu.store_items') }}</div>
                        </a>
                    </li>
                    {{-- Purchases --}}
                    <li class="menu-item {{ request()->is('admin/purchases*') ? 'active' : '' }}">
                        <a href="{{ route('admin.purchases.index') }}" class="menu-link">
                            <div>{{ __('menu.purchases_records') }}</div>
                        </a>
                    </li>
                </ul>
            </li>


            <li class="menu-header small text-uppercase"><span
                    class="menu-header-text">{{ __('menu.education_quizzes_header') }}</span></li>

            <li
                class="menu-item {{ request()->is('admin/lessons*') || request()->is('admin/quizzes*') || request()->is('admin/questions*') || request()->is('admin/quiz-*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-book-open"></i>
                    <div data-i18n="Education">{{ __('menu.lessons_quizzes') }}</div>
                </a>
                <ul class="menu-sub">
                    {{-- Lessons --}}
                    <li class="menu-item {{ request()->is('admin/lessons*') ? 'active' : '' }}">
                        <a href="{{ route('admin.lessons.index') }}" class="menu-link">
                            <div>{{ __('menu.lessons') }}</div>
                        </a>
                    </li>
                    {{-- Quizzes --}}
                    <li class="menu-item {{ request()->is('admin/quizzes*') ? 'active' : '' }}">
                        <a href="{{ route('admin.quizzes.index') }}" class="menu-link">
                            <div>{{ __('menu.quizzes') }}</div>
                        </a>
                    </li>
                    {{-- Questions --}}
                    <li class="menu-item {{ request()->is('admin/questions*') ? 'active' : '' }}">
                        <a href="{{ route('admin.questions.index') }}" class="menu-link">
                            <div>{{ __('menu.questions') }}</div>
                        </a>
                    </li>
                    {{-- Quiz Attempts --}}
                    <li class="menu-item {{ request()->is('admin/quiz-attempts*') ? 'active' : '' }}">
                        <a href="{{ route('admin.quiz-attempts.index') }}" class="menu-link">
                            <div>{{ __('menu.quiz_attempts') }}</div>
                        </a>
                    </li>
                    {{-- Quiz Answers --}}
                    <li class="menu-item {{ request()->is('admin/quiz-answers*') ? 'active' : '' }}">
                        <a href="{{ route('admin.quiz-answers.index') }}" class="menu-link">
                            <div>{{ __('menu.quiz_answers') }}</div>
                        </a>
                    </li>
                </ul>
            </li>


            <li class="menu-header small text-uppercase"><span
                    class="menu-header-text">{{ __('menu.gamification_header') }}</span></li>

            <li
                class="menu-item {{ request()->is('admin/points-transactions*') || request()->is('admin/achievements*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-star"></i>
                    <div data-i18n="Gamification">{{ __('menu.points_achievements_tracking') }}</div>
                </a>
                <ul class="menu-sub">
                    {{-- Points Transactions --}}
                    <li class="menu-item {{ request()->is('admin/points-transactions*') ? 'active' : '' }}">
                        <a href="{{ route('admin.points-transactions.index') }}" class="menu-link">
                            <div>{{ __('menu.points_records') }}</div>
                        </a>
                    </li>
                    {{-- Achievements --}}
                    <li class="menu-item {{ request()->is('admin/achievements*') ? 'active' : '' }}">
                        <a href="{{ route('admin.achievements.index') }}" class="menu-link">
                            <div>{{ __('menu.major_achievements') }}</div>
                        </a>
                    </li>
                </ul>
            </li>


            <li class="menu-header small text-uppercase"><span
                    class="menu-header-text">{{ __('menu.settings_control_header') }}</span></li>

            {{-- Notifications --}}
            <li class="menu-item {{ request()->routeIs('admin.notifications.index') ? 'active' : '' }}">
                <a href="{{ route('admin.notifications.index') }}" class="menu-link">
                    <i class="menu-icon bx bx-bell"></i>
                    <div data-i18n="Notifications">{{ __('menu.notifications') }}</div>
                </a>
            </li>

            {{-- User Settings (Combined into one group) --}}
            <li
                class="menu-item {{ request()->is('admin/user-settings*') || request()->is('admin/parental-controls*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-cog"></i>
                    <div data-i18n="System Settings">{{ __('menu.system_settings') }}</div>
                </a>
                <ul class="menu-sub">
                    {{-- User Settings --}}
                    <li class="menu-item {{ request()->is('admin/user-settings*') ? 'active' : '' }}">
                        <a href="{{ route('admin.user-settings.index') }}" class="menu-link">
                            <div>{{ __('menu.user_settings') }}</div>
                        </a>
                    </li>
                    {{-- Parental Controls --}}
                    <li class="menu-item {{ request()->is('admin/parental-controls*') ? 'active' : '' }}">
                        <a href="{{ route('admin.parental-controls.index') }}" class="menu-link">
                            <div>{{ __('menu.parental_controls') }}</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if (auth()->user()->role?->name === 'parent')
            {{-- ================== Parent Accessible Sections ================== --}}

            {{-- Kids & Related --}}
            <li class="menu-header small text-uppercase"><span>{{ __('menu.kids_progress_header') }}</span></li>
            <li class="menu-item {{ request()->is('admin/kids*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-child"></i>
                    <div>{{ __('menu.kids_management') }}</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('admin.kids.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.kids.index') }}" class="menu-link">
                            <div>{{ __('menu.kids_list') }}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.kid-achievements.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.kid-achievements.index') }}" class="menu-link">
                            <div>{{ __('menu.kid_achievements') }}</div>
                        </a>
                    </li>
                    <li
                        class="menu-item {{ request()->routeIs('admin.kid-lesson-progresses.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.kid-lesson-progresses.index') }}" class="menu-link">
                            <div>{{ __('menu.lesson_progress') }}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.kid-sessions.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.kid-sessions.index') }}" class="menu-link">
                            <div>{{ __('menu.kid_sessions') }}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.otps.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.otps.index') }}" class="menu-link">
                            <div>{{ __('menu.otps') }}</div>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Games & Daily Goals --}}
            <li class="menu-header small text-uppercase"><span>{{ __('menu.games_goals_header') }}</span></li>
            <li
                class="menu-item {{ request()->is('admin/games*') || request()->is('admin/game-kids*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-game"></i>
                    <div>{{ __('menu.games') }}</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('admin.games.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.games.index') }}" class="menu-link">
                            <div>{{ __('menu.games_list') }}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.game-kids.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.game-kids.index') }}" class="menu-link">
                            <div>{{ __('menu.kid_game_records') }}</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.daily-goals.index') ? 'active' : '' }}">
                <a href="{{ route('admin.daily-goals.index') }}" class="menu-link">
                    <i class="menu-icon bx bx-target-lock"></i>
                    <div>{{ __('menu.daily_goals') }}</div>
                </a>
            </li>

            {{-- Rewards & Store --}}
            <li class="menu-header small text-uppercase"><span>{{ __('menu.rewards_store_header') }}</span></li>
            <li class="menu-item {{ request()->routeIs('admin.rewards.index') ? 'active' : '' }}">
                <a href="{{ route('admin.rewards.index') }}" class="menu-link">
                    <i class="menu-icon bx bx-gift"></i>
                    <div>{{ __('menu.rewards') }}</div>
                </a>
            </li>
            <li
                class="menu-item {{ request()->is('admin/store-items*') || request()->is('admin/purchases*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-store"></i>
                    <div>{{ __('menu.store_purchases') }}</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('admin.store-items.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.store-items.index') }}" class="menu-link">
                            <div>{{ __('menu.store_items') }}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.purchases.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.purchases.index') }}" class="menu-link">
                            <div>{{ __('menu.purchases_records') }}</div>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Education & Quizzes --}}
            <li class="menu-header small text-uppercase"><span>{{ __('menu.education_quizzes_header') }}</span></li>
            <li
                class="menu-item {{ request()->is('admin/lessons*') || request()->is('admin/quizzes*') || request()->is('admin/questions*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-book-open"></i>
                    <div>{{ __('menu.lessons_quizzes') }}</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('admin.lessons.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.lessons.index') }}" class="menu-link">
                            <div>{{ __('menu.lessons') }}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.quizzes.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.quizzes.index') }}" class="menu-link">
                            <div>{{ __('menu.quizzes') }}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.questions.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.questions.index') }}" class="menu-link">
                            <div>{{ __('menu.questions') }}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.quiz-attempts.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.quiz-attempts.index') }}" class="menu-link">
                            <div>{{ __('menu.quiz_attempts') }}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.quiz-answers.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.quiz-answers.index') }}" class="menu-link">
                            <div>{{ __('menu.quiz_answers') }}</div>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Gamification --}}
            <li class="menu-header small text-uppercase"><span>{{ __('menu.gamification_header') }}</span></li>
            <li
                class="menu-item {{ request()->routeIs('admin.points-transactions.index') || request()->routeIs('admin.achievements.index') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-star"></i>
                    <div>{{ __('menu.points_achievements_tracking') }}</div>
                </a>
                <ul class="menu-sub">
                    <li
                        class="menu-item {{ request()->routeIs('admin.points-transactions.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.points-transactions.index') }}" class="menu-link">
                            <div>{{ __('menu.points_records') }}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.achievements.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.achievements.index') }}" class="menu-link">
                            <div>{{ __('menu.major_achievements') }}</div>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Notifications --}}
            <li class="menu-header small text-uppercase"><span>{{ __('menu.settings_control_header') }}</span></li>
            <li class="menu-item {{ request()->routeIs('admin.notifications.index') ? 'active' : '' }}">
                <a href="{{ route('admin.notifications.index') }}" class="menu-link">
                    <i class="menu-icon bx bx-bell"></i>
                    <div>{{ __('menu.notifications') }}</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.user-settings.index') ? 'active' : '' }}">
                <a href="{{ route('admin.user-settings.index') }}" class="menu-link">
                    <i class="menu-icon bx bx-cog"></i>
                    <div>{{ __('menu.user_settings') }}</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.parental-controls.index') ? 'active' : '' }}">
                <a href="{{ route('admin.parental-controls.index') }}" class="menu-link">
                    <i class="menu-icon bx bx-lock"></i>
                    <div>{{ __('menu.parental_controls') }}</div>
                </a>
            </li>
        @endif

        {{-- فقط للطفل --}}
        @if (auth()->user()->role?->name === 'kid')
            {{-- Education & Quizzes --}}
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Education & Quizzes</span>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.lessons.*') ? 'active' : '' }}">
                <a href="{{ route('admin.lessons.index') }}" class="menu-link">
                    <i class="menu-icon bx bx-book-open"></i>
                    <div>Lessons</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.quizzes.*') ? 'active' : '' }}">
                <a href="{{ route('admin.quizzes.index') }}" class="menu-link">
                    <i class="menu-icon bx bx-question-mark"></i>
                    <div>Quizzes</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.quiz-attempts.*') ? 'active' : '' }}">
                <a href="{{ route('admin.quiz-attempts.index') }}" class="menu-link">
                    <i class="menu-icon bx bx-task"></i>
                    <div>My Attempts</div>
                </a>
            </li>

            {{-- Store & Rewards --}}
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Store & Rewards</span>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.store-items.*') ? 'active' : '' }}">
                <a href="{{ route('admin.store-items.index') }}" class="menu-link">
                    <i class="menu-icon bx bx-store"></i>
                    <div>Store</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.purchases.*') ? 'active' : '' }}">
                <a href="{{ route('admin.purchases.index') }}" class="menu-link">
                    <i class="menu-icon bx bx-receipt"></i>
                    <div>My Purchases</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.rewards.*') ? 'active' : '' }}">
                <a href="{{ route('admin.rewards.index') }}" class="menu-link">
                    <i class="menu-icon bx bx-gift"></i>
                    <div>Rewards</div>
                </a>
            </li>

            {{-- Daily Goals --}}
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Goals</span>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.daily-goals.*') ? 'active' : '' }}">
                <a href="{{ route('admin.daily-goals.index') }}" class="menu-link">
                    <i class="menu-icon bx bx-target-lock"></i>
                    <div>Daily Goals</div>
                </a>
            </li>

            {{-- Profile --}}
            {{-- <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Account</span>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                <a href="{{ route('admin.profile') }}" class="menu-link">
                    <i class="menu-icon bx bx-user"></i>
                    <div>My Profile</div>
                </a>
            </li> --}}

            {{-- Gamification --}}
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Gamification</span>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.achievements.*') ? 'active' : '' }}">
                <a href="{{ route('admin.achievements.index') }}" class="menu-link">
                    <i class="menu-icon bx bx-star"></i>
                    <div>Achievements</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.points-transactions.*') ? 'active' : '' }}">
                <a href="{{ route('admin.points-transactions.index') }}" class="menu-link">
                    <i class="menu-icon bx bx-line-chart"></i>
                    <div>Points</div>
                </a>
            </li>

            {{-- Notifications --}}
            {{-- <li class="menu-item {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                <a href="{{ route('admin.notifications.index') }}" class="menu-link">
                    <i class="menu-icon bx bx-bell"></i>
                    <div>Notifications</div>
                </a>
            </li> --}}
        @endif


    </ul>
</aside>

<script>
    const toggleButton = document.querySelector('#menu-toggle-button'); // Replace with your actual button selector
    const body = document.body; // Or the main container of the sidebar

    toggleButton.addEventListener('click', () => {
        // Toggles the class 'menu-collapsed' on the body element
        body.classList.toggle('menu-collapsed');
    });
</script>
