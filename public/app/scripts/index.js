const page = document.documentElement;
const mobileCheck = matchMedia('(max-width: 959px)');

// Nav

const nav = document.querySelector('.header-nav');
const navButton = document.querySelector('.header-nav-button');

function isNavOpen() {
	return navButton.getAttribute('aria-expanded') === 'true';
}

function openNav() {
	page.classList.add('page--clip');

	navButton.setAttribute('aria-expanded', 'true');

	nav.classList.remove('header-nav--closed');
	setTimeout(() => {
		nav.classList.add('header-nav--opened'), 20
	});
}

function closeNav() {
	page.classList.remove('page--clip');

	navButton.setAttribute('aria-expanded', 'false');

	nav.classList.remove('header-nav--opened');
	nav.addEventListener('transitionend', () => {
		if (!nav.classList.contains('header-nav--opened')) {
			nav.classList.add('header-nav--closed');
		}
	}, {
		once: true
	});
}

navButton.addEventListener('click', () => {
	isNavOpen() ? closeNav() : openNav();
  closeSearch();
});

mobileCheck.addEventListener('change', (event) => {
	if (event.matches) {
	} else {
		closeNav();
	}
});


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

