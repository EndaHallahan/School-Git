const CHARS: string = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789.!?$@ ";
const CHARLENGTH: number = CHARS.length;

window.addEventListener("load", () => {
	dataBinder();
}, false);

function dataBinder(): void {
	let unboundControllers: NodeListOf<HTMLElement> = document.querySelectorAll("[data-garble-type]");
	unboundControllers.forEach(ele => {
		switch (ele.dataset.garbleType) {
			case "one-garble-three":
				new OneGarblerThree(ele);
				break;
			case "hover-garble-three":
				new HoverGarblerThree(ele);
				break;
			default:
				console.log("You misspelled something, dumbass")	
		}
	});
}

class GarblerThree {
	boundEle: HTMLElement;
	content: string;
	garbledContent: string;
	start: number | null;
	lastFrame: number;
	frameRateInterval: number;
	done: boolean;
	fixed: Array<number>;
	fixOrder: Array<number>

	constructor(ele: HTMLElement) {
		this.boundEle = ele;
		this.content = this.boundEle.textContent ? this.boundEle.textContent : "";
		this.garbledContent = "";
		this.start = null;
		this.lastFrame = 0;
		this.frameRateInterval = 1000/25;
		this.done = false;
		this.fixed = [];
		this.fixOrder = this.shuffle();
		this.garble();
		this.unhide();
	}
	begin(): void {
		this.lastFrame = Date.now();
		window.requestAnimationFrame(this.animate.bind(this));
	}
	shuffle(): Array<number> {
		let array: Array<number> = [...Array(this.content.length).keys()]
		let currentIndex: number = array.length, temporaryValue, randomIndex;
		while (0 !== currentIndex) {
		    randomIndex = Math.floor(Math.random() * currentIndex);
		    currentIndex -= 1;
		    temporaryValue = array[currentIndex];
		    array[currentIndex] = array[randomIndex];
		    array[randomIndex] = temporaryValue;
		}
		return array;
	}
	animate(timestamp: number): void {
		if (!this.start) {this.start = timestamp};
		let progress: number = timestamp - this.start;
		if (!this.done) {
	    	window.requestAnimationFrame(this.animate.bind(this));					
		} else {
			this.boundEle.textContent = this.content;
			return;
		}
		let now: number = Date.now();
		let elapsed: number = now - this.lastFrame;		
		if (elapsed > this.frameRateInterval) {
			this.garble();
			this.fix();
			this.lastFrame = now - (elapsed % this.frameRateInterval);
		}
	}
	fix(): void {
		let i: number | undefined = this.fixOrder.pop();
		if (i !== undefined) {
			let arr: Array<string> = this.garbledContent.split("");
			arr[i] = this.content[i];
			this.garbledContent = arr.join("");
			this.boundEle.textContent = this.garbledContent;
			this.fixed.push(i);
			if (this.content === this.garbledContent) {
				this.done = true;
			}
		}	
	}
	unhide(): void {
		this.boundEle.classList.remove("hidden");
	}
	garble(index?: number): void {
		this.garbledContent = "";
		if (index === undefined) {
			index = 0;
		}
		for (let i: number=index; i<this.content.length; i++ ) {
			if (this.fixed.includes(i)) {
				this.garbledContent += this.content[i];
				continue;
			}
			let newChar: string = CHARS.charAt(Math.floor(Math.random() * CHARLENGTH));
			this.garbledContent += newChar;
		}
		this.boundEle.textContent = this.garbledContent;
	}
	reset(): void {
		this.garbledContent = "";
		this.start = null;
		this.lastFrame = 0;
		this.frameRateInterval = 1000/25;
		this.done = false;
		this.fixed = [];
		this.fixOrder = this.shuffle();
		this.garble();
	}
}

class OneGarblerThree extends GarblerThree {
	constructor(ele: HTMLElement) {
		super(ele);
		this.begin();
	}
}

class HoverGarblerThree extends GarblerThree {
	constructor(ele: HTMLElement) {
		super(ele);
		this.boundEle.addEventListener("mouseover", () => {
			this.begin();
		}, false);
		this.boundEle.addEventListener("mouseout", () => {
			this.reset();
		}, false);
		
	}
}