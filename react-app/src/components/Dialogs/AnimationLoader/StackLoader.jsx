import React, { Component } from 'react';
import ExplodingStarAnimation from '../../Animations/ExplodingStarAnimationAnimation';
import StackAnimation from '../../Animations/StackAnimation';

class StackLoader extends Component {
    constructor(props) {
        super(props);
        this.state = { isStopped: false, isPaused: false, loop: true, autoplay: true };
    }

    render() {

        return (
            <div className="Lottie-Loader" >
                <div className="Lottie-Animation">
                    <StackAnimation key={"stack"} isPaused={this.state.isPaused} isStopped={this.state.isStopped} autoplay={this.state.autoplay} loop={this.state.loop} />
                </div>

            </div>
        );
    }
}

export default StackLoader;