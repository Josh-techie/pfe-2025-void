import Image from "next/image"

const Icon = ({ name, className = "h-6 w-6" }) => {
	// Extract dimensions from className
	const dimensions = className.match(/h-(\d+)/)?.[1] || "6"
	const size = parseInt(dimensions) * 4 // Convert Tailwind units to pixels (h-4 = 16px)

	return (
		<Image
			src={`/icons/${name}.svg`}
			alt={name}
			width={size}
			height={size}
			className={className}
			style={{ minWidth: size, minHeight: size }} // Ensure minimum size
		/>
	)
}

export default Icon
