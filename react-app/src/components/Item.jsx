import React, { Component } from 'react';
import { css } from 'glamor';
import { bgListStyle, flexBoxCenter, flexRow, placingStyle, modHoverStyle, textTransformStyle, placingDivStyle, bgOppacityStyle, w100 } from '../style/defaultTheme';
import Socket from './Socket';

const itemRarityColor = {
  0: {
    label: 'Normal',
    color: 'grey',
    style: {
      color: 'grey',
    }
  },
  1: {
    label: 'Magic',
    color: 'blue',
    style: {
      color: 'blue',
    }
  },
  2: {
    label: 'Rare',
    color: 'gold',
    style: {
      color: 'gold',
    }
  },
  3: {
    label: 'Unique',
    color: 'brown',
    style: {
      color: 'brown',
    }
  },
  4: {
    label: 'Reliq',
    color: 'green',
    style: {
      color: 'green',
    }
  },
}


class Item extends Component {

  constructor(props) {
    super(props)
    this.state = {
      item: props.item,
    }
  }

  filterExplicit(filtered, mod) {
    return this.filterMod(filtered, mod, 'explicit')
  }

  filterImplicit(filtered, mod) {
    return this.filterMod(filtered, mod, 'implicit')
  }

  filterMod(filtered, mod, filter) {
    if (mod.type.includes(filter)) {
      filtered.push(<p {...css(placingStyle, modHoverStyle)} onClick={(evnt) => this.props.addModFilter(mod)}>{mod.text}</p>)
    }
    return filtered;
  }

  render() {
    const implicit = this.state.item.modExts.reduce(this.filterImplicit.bind(this), []);
    const explicit = this.state.item.modExts.reduce(this.filterExplicit.bind(this), []);
    return (
      <div {...css(flexBoxCenter, flexRow, bgListStyle)}>
        <div {...css(flexBoxCenter, bgOppacityStyle, { borderRadius: '10px', position: 'relative' }, placingStyle)}>
          <img {...css({ mixBlendMode: 'default' })}
            src={this.state.item.icon}>
          </img>
          {this.state.item.socketsExt &&
            <Socket socket={this.state.item.socketsExt} w={this.state.item.w} h={this.state.item.h} ></Socket>}
        </div>
        <div {...css({ maxWidth: '550px' })}>
          <div>
            <h4 {...css({ marginBottom: '0px', ...itemRarityColor[this.state.item.frameType].style })}>{this.state.item.baseType} {this.state.item.name}</h4>
            <hr {...css({ maxWidth: '300px', borderTop: '2px', borderRadius: '3px', ...itemRarityColor[this.state.item.frameType].style })} />
          </div>
          {this.state.item.properties.length > 0 &&
            <div {...placingStyle}>
              {this.state.item.properties.reduce((filtered, prop) => {
                if (prop.type !== null) {
                  filtered.push(<p {...placingStyle} >{prop.name}: {prop.values[0][0]}</p>)
                }
                return filtered;
              }, [])}
            </div>}

          <div {...placingDivStyle}>
            {this.state.item.ilvl > 0 &&
              <p {...css(textTransformStyle, placingStyle)}>Item level: {this.state.item.ilvl}</p>}

            {this.state.item.requirements.length > 0 &&
              <p {...css(textTransformStyle, placingStyle)}>Require {this.state.item.requirements.map(
                req => req.name + ' ' + req.values[0][0]
              ).join(', ')}</p>}
          </div>

          {this.state.item.identified === false &&
            <div>
              <p>Unidentified</p>
            </div>
          }

          {implicit.length > 0 &&
            <div {...placingDivStyle}>
              {implicit}
            </div>}
          {explicit.length > 0 &&
            <div {...placingDivStyle}>
              {explicit}
            </div>}
          {/*Should only be gems*/}
          {this.state.item.modExts.length === 0 && this.state.item.explicitMods.length > 0 &&
            <div {...placingStyle}>
              {this.state.item.explicitMods.map(
                mod => <p {...placingStyle} >{mod}</p>
              )}
            </div>}

          {this.state.item.corrupted &&
            <div>
              <p>Corrupted</p>
            </div>}
        </div>
        <div {...css(flexBoxCenter)}>
          <p>toto</p>
        </div>
      </div>
    );
  }
}

export default Item;
