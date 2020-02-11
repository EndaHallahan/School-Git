window.addEventListener("load", () => {
	let logo = document.querySelector(".logo-container");
	new AniLogo(logo);
}, false);

class AniLogo {
	constructor(ele) {
		this.boundEle = ele;
		this.panels = this.boundEle.querySelectorAll(".logo-square");
		this.lastFrame = null;
		this.frameRateInterval = 1700;
		this.initDelay = 200;
		this.flipClasses = ["logo-flipped-y"/*, "logo-flipped-x"*/ /*, "logo-twisted-90"*/ /*, "logo-twisted-r90"*/];

		this.begin();
	}
	randNum(cap) {
		return Math.floor(Math.random() * Math.floor(cap));
	}
	randArrayIndex(arr) {
		return this.randNum(arr.length);
	}
	begin() {
		this.lastFrame = Date.now();
		window.requestAnimationFrame(this.animate.bind(this));	
	}
	animate(timestamp) {
		window.requestAnimationFrame(this.animate.bind(this));
		if (this.initDelay > 0) {
			this.initDelay--;
			return;
		}
		let tempPanels = [... this.panels];
		let now = Date.now();
		let elapsed = now - this.lastFrame;
		if (elapsed > this.frameRateInterval) {
			let flipNo = this.randNum(3) + 2;
			for (let i=0; i<flipNo; i++) {
				let actingPanel = tempPanels.splice(this.randArrayIndex(tempPanels), 1)[0];
				this.flip(actingPanel);
			}
			this.lastFrame = now - (elapsed % this.frameRateInterval);
		}
	}
	flip(ele) {
		if (ele.classList.length >= this.flipClasses.length + 1) {
			this.flipClasses.forEach((c) => {
				ele.classList.remove(c);
			})
		} else {
			let action = this.flipClasses[this.randArrayIndex(this.flipClasses)];
			ele.classList.add(action);
		}	
	}
}