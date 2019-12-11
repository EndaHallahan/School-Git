const THEMELIST = [
	"dark",
	"bwhite",
	"light",
]

function setTheme() {
	let themeEle = document.getElementById("theme");
	let newTheme = "";
	if (document.cookie.split(';').filter((item) => item.trim().startsWith('theme=')).length) {
		let cookieValue = document.cookie.replace(/(?:(?:^|.*;\s*)theme\s*\=\s*([^;]*).*$)|^.*$/, "$1");
	    let newThemeIndex = THEMELIST.indexOf(cookieValue) + 1;
	    if (newThemeIndex >= THEMELIST.length) {newThemeIndex = 0;}
	    newTheme = THEMELIST[newThemeIndex];
	} else {
		newTheme = THEMELIST[1];
	}
	themeEle.setAttribute("href", `http://www.ed.argabarga.org/themes/${newTheme}-style.css`);
	document.cookie = `theme=${newTheme}; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/`;
}