const page = document.documentElement;
const mobileCheck = matchMedia('(max-width: 959px)');

// Menu

const menu = document.querySelector('.header-menu');
const menuButton = document.querySelector('.header-menu-button');

function isMenuOpen() {
	return menuButton.getAttribute('aria-expanded') === 'true';
}

function openMenu() {
	page.classList.add('page--clip');

	menuButton.setAttribute('aria-expanded', 'true');

	menu.classList.remove('header-menu--closed');
	setTimeout(() => {
		menu.classList.add('header-menu--opened'), 20
	});
}

function closeMenu() {
	page.classList.remove('page--clip');

	menuButton.setAttribute('aria-expanded', 'false');

	menu.classList.remove('header-menu--opened');
	menu.addEventListener('transitionend', () => {
		if (!menu.classList.contains('header-menu--opened')) {
			menu.classList.add('header-menu--closed');
		}
	}, {
		once: true
	});
}

menuButton.addEventListener('click', () => {
	isMenuOpen() ? closeMenu() : openMenu();
	closeSearch();
});

mobileCheck.addEventListener('change', (event) => {
	if (event.matches) {
	} else {
		closeMenu();
	}
});

document.querySelectorAll('.js-menu-slide-open').forEach((function(button) {
	const slide = button.nextElementSibling;
	button.addEventListener('click', () => {
		slide.classList.remove('menu-slide--closed');
		setTimeout(() => {
			slide.classList.add('menu-slide--opened'), 20
		});
	});
}))

document.querySelectorAll('.js-menu-slide-close').forEach((function(button) {
	const slide = button.parentNode;
	button.addEventListener('click', () => {
		slide.classList.remove('menu-slide--opened');
		slide.addEventListener('transitionend', () => {
			if (!slide.classList.contains('menu-slide--opened')) {
				slide.classList.add('menu-slide--closed');
			}
		}, {
			once: true
		});
	});
}))

// Sidenav

document.querySelectorAll('.js-sidenav-toggle').forEach((function(button) {
	button.addEventListener('click', () => {
		const list = button.parentNode.nextElementSibling;

		if ( list.classList.contains('is-active') ) {
			button.setAttribute('aria-expanded', false);
			list.classList.remove('is-active')
		} else {
			button.setAttribute('aria-expanded', true);
			list.classList.add('is-active')
		}
	});
}))

// Search

const search = document.querySelector('.header-search');
const searchButton = document.querySelector('.header-search-toggle');
const searchInput = document.querySelector('.header-search-input');

function isSearchOpen() {
	return searchButton.getAttribute('aria-expanded') === 'true';
}

function openSearch() {
	searchButton.setAttribute('aria-expanded', 'true');

	search.classList.remove('header-search--closed');
	setTimeout(() => {
		search.classList.add('header-search--opened'), 20
	});

	searchInput.focus();
}

function closeSearch() {
	searchButton.setAttribute('aria-expanded', 'false');

	search.classList.remove('header-search--opened');
	search.addEventListener('transitionend', () => {
		if (!search.classList.contains('header-search--opened')) {
			search.classList.add('header-search--closed');
		}
	}, {
		once: true
	});

	searchInput.blur();
}

searchButton.addEventListener('click', () => {
	isSearchOpen() ? closeSearch() : openSearch();
});

mobileCheck.addEventListener('change', (event) => {
	if (event.matches) {
	} else {
		closeSearch();
	}
});
