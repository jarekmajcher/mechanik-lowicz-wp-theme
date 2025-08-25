import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks } from '@wordpress/block-editor';

/**
 * Tabs
 */
registerBlockType('theme/tabs', {
  title: 'Taby',
  icon: 'screenoptions',
  category: 'layout',
  edit: () => {
    return (
      <div className="theme-block-tabs">
        <InnerBlocks
          allowedBlocks={['theme/tabs-element']}
          template={[
            ['theme/tabs-element']
          ]}
          templateLock={false}
        />
      </div>
    );
  },
  save: () => {
    return <InnerBlocks.Content />;
  }
});

/**
 * Tab
 */
registerBlockType('theme/tabs-element', {
  title: 'Element',
  icon: 'excerpt-view',
  category: 'layout',
  parent: ['theme/tabs'],
  attributes: {
    title: { type: 'string', default: '' }
  },
  edit: ({ attributes, setAttributes }) => {
    const { title } = attributes;

    return (
      <div className="theme-block-tabs-element">
        <div className="theme-block-tabs-element__title">
          <input
            type="text"
            placeholder="Nazwa elementu"
            value={title}
            onChange={(e) => setAttributes({ title: e.target.value })}
            style={{ width: '100%' }}
          />
        </div>
        <div className="theme-block-tabs-element__content">
          <InnerBlocks />
        </div>
      </div>
    );
  },
  save: () => {
    return <InnerBlocks.Content />;
  }
});
