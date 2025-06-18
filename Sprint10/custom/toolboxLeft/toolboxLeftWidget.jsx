export const config = {
	id: "custom_dynamic_fields:Toolbox-left",
}

const ToolboxLeft = ({ data }) => {
	const socialLinks = data?.components || []

	return (
		<div className="fixed left-6 top-1/2 z-40 hidden -translate-y-1/2 transform lg:block">
			<div className="flex flex-col items-center gap-1 rounded-xl bg-[#0178F6] px-2 py-3">
				{socialLinks.map((item, index) => (
					<a
						key={index}
						href={item.cta.url}
						className="group relative rounded-lg p-1.5"
						title={item.cta.title}
					>
						<div className="text-white transition-colors duration-200 ease-in-out group-hover:text-[#3c3c3c]">
							{/* Social Icons */}
							{item.icon === "icon-facebook" && (
								<svg className="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
									<path d="M18.77,7.46H14.5v-1.9c0-.9.6-1.1,1-1.1h3V.5h-4.33C10.24.5,9.5,3.44,9.5,5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4Z" />
								</svg>
							)}
							{item.icon === "icon-twitter" && (
								<svg className="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
									<path d="M23.44,4.83c-.8.37-1.66.62-2.56.73.92-.55,1.63-1.43,1.96-2.48-.87.52-1.83.9-2.85,1.1A4.48,4.48,0,0,0,12,7.93,12.71,12.71,0,0,1,2.91,3.7,4.48,4.48,0,0,0,4.19,9.5,4.44,4.44,0,0,1,1.76,8.86v.06A4.48,4.48,0,0,0,5.33,13.3a4.49,4.49,0,0,1-2,.08A4.48,4.48,0,0,0,7.5,16.51,9,9,0,0,1,1.2,18.32,12.65,12.65,0,0,0,8,20c8.16,0,12.62-6.76,12.62-12.62,0-.19,0-.38-.01-.57C21.5,6.37,22.57,5.67,23.44,4.83Z" />
								</svg>
							)}
							{item.icon === "icon-youtube" && (
								<svg className="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
									<path d="M23.5,6.2A3,3,0,0,0,21.4,4c-1.9-.5-9.4-.5-9.4-.5s-7.5,0-9.4.5A3,3,0,0,0,.5,6.2,31.5,31.5,0,0,0,0,12a31.5,31.5,0,0,0,.5,5.8A3,3,0,0,0,2.6,20c1.9.5,9.4.5,9.4.5s7.5,0,9.4-.5a3,3,0,0,0,2.1-2.2A31.5,31.5,0,0,0,24,12,31.5,31.5,0,0,0,23.5,6.2ZM9.6,15.6V8.4l6.2,3.6Z" />
								</svg>
							)}
							{item.icon === "icon-linkedin" && (
								<svg className="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
									<path d="M20.5,2h-17A1.5,1.5,0,0,0,2,3.5v17A1.5,1.5,0,0,0,3.5,22h17A1.5,1.5,0,0,0,22,20.5v-17A1.5,1.5,0,0,0,20.5,2ZM8,19H5V8H8ZM6.5,6.73A1.77,1.77,0,1,1,8.25,5,1.75,1.75,0,0,1,6.5,6.73ZM19,19H16V13.4c0-3.37-4-3.12-4,0V19H9V8h3V9.77c1.4-2.59,7-2.78,7,2.47Z" />
								</svg>
							)}
						</div>
					</a>
				))}
			</div>
		</div>
	)
}

export default ToolboxLeft
