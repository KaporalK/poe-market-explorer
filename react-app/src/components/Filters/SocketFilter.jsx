import React, { Component } from 'react';
import TextField from '@mui/material/TextField';
import { flexBoxCenter } from '../../style/defaultTheme'
import { css } from 'glamor';

const placing = css({
  '> * > *': {
    margin: '2px'
  }
})

class SocketFilter extends Component {

  constructor(props) {
    super(props)
    this.state = {
      addFilter: props.addFilter,
      className: props.className,
      valueW: '',
      valueB: '',
      valueG: '',
      valueR: '',
      valueSocketCount: '',
      valueLink: '',
    }
  }

  handleChange(evnt, inputName) {
    const key = 'socket' + inputName;
    const stateName = 'value' + inputName.charAt(0).toUpperCase() + inputName.slice(1);
    this.state.addFilter({
      [key]: { str: 'socketsExt.' + inputName + '[gte]=' + evnt.target.value }
    })
    this.setState({
      [stateName]: evnt.target.value
    })
  }

  clearFilter() {
    this.setState({
      valueW: '',
      valueB: '',
      valueG: '',
      valueR: '',
      valueSocketCount: '',
      valueLink: '',
    })
  }

  render() {
    return (
      <div className={"socketFilter " + this.state.className}>
        <div {...css(flexBoxCenter, placing)}>
          <TextField id="W" label="W" variant="filled"
            onChange={evt => this.handleChange(evt, 'W')}
            value={this.state.valueW} />
          <TextField id="R" label="R" variant="filled"
            onChange={evt => this.handleChange(evt, 'R')}
            value={this.state.valueR} />
          <TextField id="G" label="G" variant="filled"
            onChange={evt => this.handleChange(evt, 'G')}
            value={this.state.valueG} />
          <TextField id="B" label="B" variant="filled"
            onChange={evt => this.handleChange(evt, 'B')}
            value={this.state.valueB} />
        </div>
        <div {...css(flexBoxCenter, placing)}>
          <TextField id="MinS" label="Min Sockets" variant="filled"
            onChange={evt => this.handleChange(evt, 'socketCount')}
            value={this.state.valueSocketCount} />
          <TextField id="MinL" label="Min Links" variant="filled"
            onChange={evt => this.handleChange(evt, 'link')}
            value={this.state.valueLink} />
        </div>
      </div>
    );
  }
}

export default SocketFilter;
