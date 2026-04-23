export const capitalizeFirstLetter = (text: string) => {
    if (text.length < 2) return text;
    return text.charAt(0).toUpperCase() + text.slice(1, text.length);
};
