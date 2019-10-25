module.exports = ({file, options, env}) => ({
	plugins: {
		'postcss-cssnext': {
			'browsers': [
				'Explorer >= 11',
				'last 2 versions'
			]
		}
	}
});
