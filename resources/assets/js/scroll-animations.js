window.addEventListener('load', () => {

    const windowHeight = window.innerHeight;
    const bodyHeight = document.querySelector('body').clientHeight;

    const elementsToAnimate = document.querySelectorAll('.animate');

    const inView = element => {
        const scrollY = window.scrollY || window.pageYOffset;

        const scrollPosition = scrollY + windowHeight;

        const treshold = (windowHeight / 6);

        const elementPosition = element.getBoundingClientRect().top + scrollY + treshold;

        if (scrollPosition > elementPosition || scrollPosition >= bodyHeight - treshold) {
            return true;
        }

        return false;
    };

    const animate = () => {
        elementsToAnimate.forEach(element => {
            if (inView(element)) {
                element.classList.add('visible');
            }
        });
    };

    animate();

    document.addEventListener('scroll', animate);

});
