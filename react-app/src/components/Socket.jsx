import React, { Component } from 'react';
import { css } from 'glamor';
import { flexBoxCenter, w100, h100, flexColumn, flexRow } from '../style/defaultTheme';


const socketImg = {
  G: {
    backgroundPosition: '-35px -105px'
  },
  R: {
    backgroundPosition: '-140px 0px'
  },
  B: {
    backgroundPosition: '-105px 0px'
  },
  W: {
    backgroundPosition: '-140px -35px'
  },
  linkH: {
    backgroundPosition: '-70px -140px'
  },
  linkV: {
    backgroundPosition: '-175px 0px'
  }
}

const socketPos = {
  socket: {
    background: "url('https://web.poecdn.com/image/gen/socket.png') no-repeat",
    justifySelf: 'center',
    alignSelf: 'center',
    width: '35px',
    height: '35px',
    position: {
      3: { gridColumn: 2, gridRow: 2 },
      4: { gridColumn: 1, gridRow: 2 },
    }
  },
  link: {
    0: {
      width: '38px',
      height: '15px',
      backgroundPosition: '-70px -140px'
    },
    1: {
      width: '15px',
      height: '38px',
      backgroundPosition: '-175px 0px'
    },
    position: {
      1: {
        2: {
          position: 'absolute', top: 28, left: 22
        },
        3: {
          position: 'absolute', top: 76, left: 22
        },
      },
      2: {
        2: {
          position: 'absolute', top: 16, left: 28
        },
        3: {
          position: 'absolute', top: 28, left: 63
        },
        4: {
          position: 'absolute', top: 64, left: 28
        },
        5: {
          position: 'absolute', top: 74, left: 16
        },
        6: {
          position: 'absolute', top: 111, left: 28
        },
      }
    }
  },

  linkH: {
    width: '38px',
    height: '15px',
  },
  linkV: {
    width: '15px',
    height: '38px',
  },
}
class Socket extends Component {

  constructor(props) {
    super(props)
    this.state = {
      provider: 'https://web.poecdn.com/image/gen/socket.png'
    }
  }

  render() {
    const links = this.props.socket.linkStr.split(' ');
    const display = this.props.w === 1 ? flexColumn : flexRow
    let displayGrid = {
      display: 'grid',
      ...(this.props.w === 2 ? { gridTemplateColumns: '50% 50%', gridTemplateRows: '50% 50%' } : {}),
      ...(this.props.h > 2 ? { gridTemplateRows: '33% 33% 33%' } : {}),
      ...(this.props.h === 1 && this.props.w === 1 ? { gridTemplateRows: '100%', gridTemplateColumns: '100%' } : {}),
    }
    const position = {
      position: 'absolute',
      top: 0,
      left: 0,
      ...((this.props.h > 2 && this.props.w === 2) ? { height: '142px', left: '5px' } : {}),
      ...((this.props.h === 4) ? { top: '23px', height: '142px' } : {}),
      ...(this.props.w === 2 ? { width: '94px', left: '5px' } : {}),
    }
    let currentSocket = 0;
    return (
      <div className="socket" {...css(displayGrid, w100, h100, position)} key='socket-test'>
        {links.map((link) => {
          return link.split('').map((color) => {
            currentSocket++;
            const gridPosition = this.props.w !== 1 ? socketPos.socket.position[currentSocket] : {};
            return <div index={currentSocket} {...css({ ...socketPos.socket }, { ...socketImg[color] }, { ...gridPosition })} ></div>
          }).reduce((prev, curr) => [
            prev,
            <div {...css(socketPos.socket, socketPos.link[(this.props.w !== 1 ? curr.props.index % 2 : 1)], socketPos.link.position[this.props.w][curr.props.index])}></div>,
            curr
          ])
        })}
      </div>
    );
  }
}

export default Socket;
