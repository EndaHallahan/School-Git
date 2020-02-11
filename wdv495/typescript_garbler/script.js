"use strict";
const CHARS = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789.!?$@ ";
const CHARLENGTH = CHARS.length;
window.addEventListener("load", () => {
    dataBinder();
}, false);
function dataBinder() {
    let unboundControllers = document.querySelectorAll("[data-garble-type]");
    unboundControllers.forEach(ele => {
        switch (ele.dataset.garbleType) {
            case "one-garble-three":
                new OneGarblerThree(ele);
                break;
            case "hover-garble-three":
                new HoverGarblerThree(ele);
                break;
            default:
                console.log("You misspelled something, dumbass");
        }
    });
}
class GarblerThree {
    constructor(ele) {
        this.boundEle = ele;
        this.content = this.boundEle.textContent ? this.boundEle.textContent : "";
        this.garbledContent = "";
        this.start = null;
        this.lastFrame = 0;
        this.frameRateInterval = 1000 / 25;
        this.done = false;
        this.fixed = [];
        this.fixOrder = this.shuffle();
        this.garble();
        this.unhide();
    }
    begin() {
        this.lastFrame = Date.now();
        window.requestAnimationFrame(this.animate.bind(this));
    }
    shuffle() {
        let array = [...Array(this.content.length).keys()];
        let currentIndex = array.length, temporaryValue, randomIndex;
        while (0 !== currentIndex) {
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;
            temporaryValue = array[currentIndex];
            array[currentIndex] = array[randomIndex];
            array[randomIndex] = temporaryValue;
        }
        return array;
    }
    animate(timestamp) {
        if (!this.start)
            this.start = timestamp;
        let progress = timestamp - this.start;
        if (!this.done) {
            window.requestAnimationFrame(this.animate.bind(this));
        }
        else {
            this.boundEle.textContent = this.content;
            return;
        }
        let now = Date.now();
        let elapsed = now - this.lastFrame;
        if (elapsed > this.frameRateInterval) {
            this.garble();
            this.fix();
            this.lastFrame = now - (elapsed % this.frameRateInterval);
        }
    }
    fix() {
        let i = this.fixOrder.pop();
        if (i !== undefined) {
            let arr = this.garbledContent.split("");
            arr[i] = this.content[i];
            this.garbledContent = arr.join("");
            this.boundEle.textContent = this.garbledContent;
            this.fixed.push(i);
            if (this.content === this.garbledContent) {
                this.done = true;
            }
        }
    }
    unhide() {
        this.boundEle.classList.remove("hidden");
    }
    garble(index) {
        this.garbledContent = "";
        if (index === undefined) {
            index = 0;
        }
        for (let i = index; i < this.content.length; i++) {
            if (this.fixed.includes(i)) {
                this.garbledContent += this.content[i];
                continue;
            }
            let newChar = CHARS.charAt(Math.floor(Math.random() * CHARLENGTH));
            this.garbledContent += newChar;
        }
        this.boundEle.textContent = this.garbledContent;
    }
    reset() {
        this.garbledContent = "";
        this.start = null;
        this.lastFrame = 0;
        this.frameRateInterval = 1000 / 25;
        this.done = false;
        this.fixed = [];
        this.fixOrder = this.shuffle();
        this.garble();
    }
}
class OneGarblerThree extends GarblerThree {
    constructor(ele) {
        super(ele);
        this.begin();
    }
}
class HoverGarblerThree extends GarblerThree {
    constructor(ele) {
        super(ele);
        this.boundEle.addEventListener("mouseover", () => {
            this.begin();
        }, false);
        this.boundEle.addEventListener("mouseout", () => {
            this.reset();
        }, false);
    }
}
