import React, { Component } from 'react';
import Lottie from 'react-lottie';
import * as animationData from '../../assets/exploding_star.json'

class ExplodingStarAnimation extends Component {
    constructor(props) {
        super(props);
        this.state = { isStopped: props.isStopped, isPaused: props.isPaused, loop: props.loop, autoplay: props.autoplay };
    }

    render() {
        const defaultOptions = {
            loop: this.state.loop,
            autoplay: this.state.autoplay,
            animationData: animationData,
            rendererSettings: {
                preserveAspectRatio: 'xMidYMid slice'
            }
        };

        return (
            <Lottie options={defaultOptions}
                height={100}
                width={100}
                isStopped={this.state.isStopped}
                isPaused={this.state.isPaused} />
        );
    }
}

export default ExplodingStarAnimation;