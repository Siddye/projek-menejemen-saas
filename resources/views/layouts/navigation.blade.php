@php
    $currentUser = Auth::user();
    $currentWsId = session('current_workspace_id');
    $currentWs = $currentWsId ? \App\Models\Workspace::find($currentWsId) : $currentUser?->workspaces()->first();
    $membership = $currentWs ? $currentWs->getMembershipFor($currentUser) : null;
    $roleName = $membership ? ucfirst($membership->role) : ($currentWs && $currentWs->owner_id === $currentUser->id ? 'Owner' : 'User');
    $jobTitle = $membership?->job_title;

    $pendingReviewCount = 0;
    if ($currentWs) {
        $pendingReviewCount = \App\Models\Task::whereHas('project', function ($q) use ($currentWs) {
            $q->where('workspace_id', $currentWs->id);
        })->where('status', 'review')->count();
    }
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-xs">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <div class="w-9 h-9 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-sm">
                            PM
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-gray-900 leading-tight">DigitalSaaS</span>
                            <span class="text-[10px] text-gray-500 font-medium">Task & Workflow Management</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:ms-8 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <svg class="w-4 h-4 me-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('workspaces.index')" :active="request()->routeIs('workspaces.*') && !request()->routeIs('workspaces.review-queue')">
                        <svg class="w-4 h-4 me-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        {{ __('Workspaces') }}
                    </x-nav-link>

                    @if ($currentWs)
                        <x-nav-link :href="route('workspaces.review-queue', $currentWs)" :active="request()->routeIs('workspaces.review-queue')">
                            <svg class="w-4 h-4 me-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ __('Review Antrean') }}
                            @if ($pendingReviewCount > 0)
                                <span class="ms-1.5 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-amber-900 bg-amber-100 rounded-full">
                                    {{ $pendingReviewCount }}
                                </span>
                            @endif
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Role Indicator & User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 sm:space-x-4">
                <!-- Active Role & Workspace Badge -->
                <div class="flex items-center gap-2 px-3 py-1 bg-gray-50 border border-gray-200 rounded-full text-xs">
                    <span class="w-2 h-2 rounded-full {{ $roleName === 'Owner' ? 'bg-purple-500' : 'bg-emerald-500' }}"></span>
                    <span class="font-semibold text-gray-700">{{ $roleName }}</span>
                    @if ($jobTitle)
                        <span class="text-gray-400">&bull;</span>
                        <span class="text-indigo-600 font-medium">{{ $jobTitle }}</span>
                    @endif
                </div>

                <!-- Fast Demo Role Switcher Dropdown -->
                <x-dropdown align="right" width="60">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 focus:outline-none transition">
                            <svg class="w-3.5 h-3.5 me-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                            <span>Ganti Role Demo</span>
                            <svg class="ms-1 h-3.5 w-3.5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 text-xs font-semibold text-gray-500 border-b border-gray-100 uppercase tracking-wider">
                            Pilih Akun Demo (Role.md)
                        </div>
                        <a href="{{ route('quick-login', 'raffi@agency.com') }}" class="flex items-center justify-between px-4 py-2 text-xs text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition">
                            <div>
                                <span class="font-bold">Raffi</span> (Owner / PM)
                                <div class="text-[11px] text-gray-400">raffi@agency.com</div>
                            </div>
                            <span class="px-1.5 py-0.5 text-[10px] bg-purple-100 text-purple-700 rounded font-bold">Owner</span>
                        </a>
                        <a href="{{ route('quick-login', 'rasya@agency.com') }}" class="flex items-center justify-between px-4 py-2 text-xs text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition">
                            <div>
                                <span class="font-bold">Rasya Chaniago</span>
                                <div class="text-[11px] text-gray-400">Graphic Designer</div>
                            </div>
                            <span class="px-1.5 py-0.5 text-[10px] bg-emerald-100 text-emerald-700 rounded font-bold">Member</span>
                        </a>
                        <a href="{{ route('quick-login', 'melda@agency.com') }}" class="flex items-center justify-between px-4 py-2 text-xs text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition">
                            <div>
                                <span class="font-bold">Melda Munisa</span>
                                <div class="text-[11px] text-gray-400">Content Creator</div>
                            </div>
                            <span class="px-1.5 py-0.5 text-[10px] bg-emerald-100 text-emerald-700 rounded font-bold">Member</span>
                        </a>
                        <a href="{{ route('quick-login', 'popita@agency.com') }}" class="flex items-center justify-between px-4 py-2 text-xs text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition">
                            <div>
                                <span class="font-bold">Popita Sari</span>
                                <div class="text-[11px] text-gray-400">Social Media Specialist</div>
                            </div>
                            <span class="px-1.5 py-0.5 text-[10px] bg-emerald-100 text-emerald-700 rounded font-bold">Member</span>
                        </a>
                    </x-slot>
                </x-dropdown>

                <!-- Profile Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:text-gray-900 focus:outline-none transition ease-in-out duration-150">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-sm me-2">
                                {{ strtoupper(substr($currentUser->name, 0, 1)) }}
                            </div>
                            <div class="text-left">
                                <div class="font-semibold text-xs text-gray-900 leading-tight">{{ $currentUser->name }}</div>
                                <div class="text-[11px] text-gray-500">{{ $currentUser->email }}</div>
                            </div>

                            <div class="ms-1 text-gray-400">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil Akun') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-red-600 hover:text-red-700">
                                {{ __('Keluar (Log Out)') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('workspaces.index')" :active="request()->routeIs('workspaces.*') && !request()->routeIs('workspaces.review-queue')">
                {{ __('Workspaces') }}
            </x-responsive-nav-link>

            @if ($currentWs)
                <x-responsive-nav-link :href="route('workspaces.review-queue', $currentWs)" :active="request()->routeIs('workspaces.review-queue')">
                    {{ __('Review Antrean') }} ({{ $pendingReviewCount }})
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="px-4 py-2 bg-gray-50 border-t border-b border-gray-200">
            <div class="text-xs font-semibold text-gray-500 mb-1">GANTI ROLE CEPAT (STUDI KASUS):</div>
            <div class="grid grid-cols-2 gap-1 text-xs">
                <a href="{{ route('quick-login', 'raffi@agency.com') }}" class="p-1 bg-white border rounded text-purple-700">Raffi (Owner)</a>
                <a href="{{ route('quick-login', 'rasya@agency.com') }}" class="p-1 bg-white border rounded text-emerald-700">Rasya (Designer)</a>
                <a href="{{ route('quick-login', 'melda@agency.com') }}" class="p-1 bg-white border rounded text-emerald-700">Melda (Content)</a>
                <a href="{{ route('quick-login', 'popita@agency.com') }}" class="p-1 bg-white border rounded text-emerald-700">Popita (Sosmed)</a>
            </div>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ $currentUser->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ $currentUser->email }} &bull; <span class="text-indigo-600 font-semibold">{{ $roleName }} ({{ $jobTitle ?? 'Member' }})</span></div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profil Akun') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600">
                        {{ __('Keluar (Log Out)') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
